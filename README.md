# kafka-synced

# Установка
Используйте [composer](https://getcomposer.org/) для установки


```
composer req idynsys/synced-module
```

* 1. в случае возниковения проблем с зависимостями необходимо использовать ключ -W `composer req idynsys/synced-module -W`
  2. для работы пакета необходимо установить ext-kafka

#
## Установка (общее)
1. необходимо добавить в app.php
   >Ids\Modules\Synced\Providers\SyncedServiceProvider::class

2. Добавим файл конфига
   >php artisan vendor:publish --tag=synced-config
   


3. Запустить
   php artisan vendor:publish --tag=laravel-kafka-config
   php artisan vendor:publish --provider="Ids\Modules\Synced\SyncedServiceProvider"

   После, необходимо сконфигурировать kafka.php (если не настроен или ранее mateusjunges/laravel-kafka)
   см. https://junges.dev/documentation/laravel-kafka/v1.8/3-installation-and-setup
   необходимые мин  ENV для добавления в .env:
   >KAFKA_BROKERS: localhost:9092
   >KAFKA_CONSUMER_GROUP_ID: 'group'

* после настройки брокера и добавления в .env, необходимо убедиться в доступности брокера kafka по сети (для docker compose необходимо настроить общую сеть)


#
### Добавление модели для отправки в кафку 

4. Для добавления модели необходимо
    1. Добавить интерфейс SyncedModelInterface и трейт (для отслеживания изменение модели)
    2. Зарегистрировать события в конструкторе
    3. Реализовать методы:
```
   public function getRouteKey(): string; //название маршрута (используется как основной топик)
   public function getSyncedAttributes(): array; // подготовленные данные к отправке в топик
   public function getTopics(): array; //дополнительные топики
```

> где RouteKey должен определить название назначение сущности, SyncedAttributes должне вернуть массив данных передаваемый для обмена, Topics - набор топиков которые мы будем использовать для трансфера дополнительно

Полный пример
```
class User implements SyncedModelInterface
{
    use Synced;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->registerSyncedListeners();
    }
    /**
     * route key of model
     */
    public function getRouteKey(): string
    {
        return 'user';
    }

    /**
     * prepare attributes to recieve
     */
    public function getSyncedAttributes(): array
    {
        return $this->toArray();
    }

    /**
     * additional topics 
     */
    public function getTopics(): array
    {
        return [];
    }
}
```


#
### Добавление consumer для чтения изменений 

5. Для получения изменений на стороне клиента необходимо реализовать класс репозитория с интерфейсом SyncedRepositoryInterface:
```
public function createByKafka(KafkaPublishData $data);
public function updateByKafka(KafkaPublishData $data);
public function deleteByKafka(KafkaPublishData $data);
```
createByKafka - создание записи
updateByKafka - обновление
deleteByKafka - удаление

и сконфигурировать репозитории в файле synced.php:
    
```
    'repositories' => [
        'product' => 'App\Modules\Products\Repositories\ProductRepository',
        'organization' => 'App\Modules\Organizations\Repositories\OrganizationRepository',
        'application' => 'App\Modules\Applications\Repositories\ApplicationRepository',
    ],
```

Далее, достаточно просто, запустить коньсьюмер командой:

`php artisan synced:consume:entity`

* название команды можно изменить в synced.php в параметре `command-signature`
