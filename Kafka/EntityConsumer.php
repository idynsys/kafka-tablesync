<?php

namespace Ids\Modules\Synced\Kafka;


use Exception;
use Ids\Modules\Synced\Repository\RepositoryLocator;
use Ids\Modules\Synced\Service\KafkaPublisherDataFactory;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Contracts\CanConsumeMessages;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\ConsumedMessage;
use Throwable;

class EntityConsumer
{
    private KafkaPublisherDataFactory $kafkaPublisherDataFactory;
    private RepositoryLocator $repositoryLocator;


    public function __construct()
    {
        Log::debug(__CLASS__.' - object is created');
        $this->kafkaPublisherDataFactory = app(KafkaPublisherDataFactory::class);
        $this->repositoryLocator = app(RepositoryLocator::class);

        //register repositories
        foreach (config('synced.repositories') as $route => $repoClass) {
            $this->repositoryLocator->registerSyncedRepository($route, app($repoClass));
        }
    }

    private function handle(): CanConsumeMessages
    {
        Log::debug('consumer is handling ...');

        return Kafka::createConsumer()
            ->subscribe($this->repositoryLocator->getRoutes())
            ->withConsumerGroupId(config('kafka.consumer_group_id'))
            ->withHandler(function (ConsumedMessage $message) {
                $this->handleMessage($message);
            })
            ->build();
    }

    /**
     * @throws Exception
     */
    private function handleMessage(ConsumedMessage $message): void
    {
        $kafkaPublishData = $this->kafkaPublisherDataFactory->createByData($message->getBody()['body']);
        Log::debug('received data:'.print_r($message->getBody(), true));
        if ($kafkaPublishData) {
            Log::debug(
                \sprintf('try to process:%s:%s', $kafkaPublishData->getEvent(), $kafkaPublishData->getRoutingKey())
            );
            $this->repositoryLocator->process($kafkaPublishData);
            Log::debug('done');
        } else {
            throw new Exception('There is no data to process '.$message->getTopicName());
        }
    }

    public function consume(): void
    {
        try {
            $this->handle()->consume();
        } catch (Throwable $exception) {
            Log::debug($exception->getMessage());
            $this->consume();
        }
    }
}
