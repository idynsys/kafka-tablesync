# kafka-synced

# Установка
Используйте [composer](https://getcomposer.org/) для установки

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url":  "<путь и доступы к репозиторию пакета, если не публичный>"
    }
  ]
}
```
```
composer req idynsys/synced-module
```

#установка
1. необходимо добавить в app.php
   >Ids\Modules\Synced\Providers\SyncedServiceProvider::class

2. Добавим файл конфига
   >php artisan vendor:publish --tag=synced-config

   Далее необходимо сконфигурировать репозитории, реализующие интерфейс записи данных:`SyncedRepositoryInterface`
  'SyncedRepositoryInterface', например:
```
    'repositories' => [
        'product' => 'App\Modules\Products\Repositories\ProductRepository',
        'organization' => 'App\Modules\Organizations\Repositories\OrganizationRepository',
        'application' => 'App\Modules\Applications\Repositories\ApplicationRepository',
    ],
```


3. Запустить
   php artisan vendor:publish --tag=laravel-kafka-config
   php artisan vendor:publish --provider="Ids\Modules\Synced\SyncedServiceProvider"

   После, необходимо сконфигурировать kafka.php (если не настроена kafka)


4. Добавить интерфейс SyncedModelInterface и  трейт (для отслеживания изменение модели)
```
use Synced; 
```
5. Зарегистрировать события в конструкторе, например:
```
        public function __construct(array $attributes = [])
        {
            parent::__construct($attributes);
            $this->registerSyncedListeners();
        }
```
6. Реализовать методы
```
    public function getRouteKey(): string;
    public function getSyncedAttributes(): array;
    public function getTopics(): array;
```
где RouteKey должен определить название назначение сущности(название),
    SyncedAttributes должне вернуть массив данных передаваемый для обмена
    Topics - набор топиков в которые закинем модель (по умолначию synced)
