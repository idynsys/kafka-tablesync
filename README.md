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
   Ids\Modules\Synced\Providers\SyncedServiceProvider::class

2. Добавить в modules_statuses.json 
```
{
   "UserAccess": true,
   "Synced": true
   }
```

3. Запустить
   php artisan vendor:publish --provider="Ids\Modules\Synced\SyncedServiceProvider"

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
```
где RouteKey должен определить название назначение сущности(название),
    SyncedAttributes должне вернуть массив данных передаваемый для обмена
