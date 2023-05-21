<?php

namespace Ids\Modules\Synced\Console;

use Ids\Modules\Synced\Service\KafkaPublisherDataFactory;
use Ids\Modules\Synced\Service\KafkaSender;
use Illuminate\Support\Facades\Log;
use RdKafka\KafkaConsumer;
use ThiagoBrauer\LaravelKafka\Console\Commands\ConsumerCommand;

class SyncedConsumerCommand extends ConsumerCommand
{
    private KafkaPublisherDataFactory $kafkaPublisherDataFactory;

    public function __construct()
    {
        parent::__construct();
        $this->kafkaPublisherDataFactory = app(KafkaPublisherDataFactory::class);
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \JsonException
     */
    public function handle()
    {
        $options = $this->getContextOptions();

        $messageHandlers = config('laravel_kafka.message_handlers');
        $this->validateMessageHandlers($messageHandlers);

        $consumer = new KafkaConsumer($this->getConfig());
        $consumer->subscribe([KafkaSender::TOPIC_NAME]);

        while (true) {
            /** @var RdKafka\Message $message */
            $message = $consumer->consume($options['timeout_ms']);

            $body = json_decode($message->payload, true, 512, JSON_THROW_ON_ERROR)['body'];

            $kafkaPublishData = $this->kafkaPublisherDataFactory->createByJson($body);

            switch ($message->err) {
                case RD_KAFKA_RESP_ERR_NO_ERROR:
                    $topic = $message->topic_name;
                    Log::debug("Receiving message: topic_name " . $message->topic_name . ", offset " . $message->offset . "\n");




                    // Commit offsets asynchronously
                    if ($options['commit_async']) {
                        $consumer->commitAsync($message);
                    } else {
                        $consumer->commit($message);
                    }

                    if ($options['once']) {
                        return;
                    }

                    break;

                case RD_KAFKA_RESP_ERR__PARTITION_EOF:
                    echo "No more messages; will wait for more\n";
                    break;

                case RD_KAFKA_RESP_ERR__TIMED_OUT:
                    Log::debug("Timed out\n");
                    break;

                default:
                    Log::debug($message->errstr().'('.$message->err.')');
                    break;
            }
        }
    }
}
