# kafka-synced

# Установка
Используйте [composer](https://getcomposer.org/) для установки


```json
{
  "repositories": [
    {
      "type": "vcs",
      "url":  "git@gitlab.idynsys.org:wlb_project/b2b/kafka-synced.git"
    }
  ]
}
```
```
composer req ids/synced
```

#установка
1. необходимо добавить в app.php
   Ids\Modules\Synced\Providers\SyncedServiceProvider::class

2. запустить
   php artisan vendor:publish --provider="Ids\Modules\Synced\SyncedServiceProvider"

3. добавить интерфейс SyncedModelInterface и  трейт (для отслеживания изменение модели)
```
use Synced; 
```
4. зарегистрировать события в конструкторе, например:
```
        public function __construct(array $attributes = [])
        {
            parent::__construct($attributes);
            $this->registerSyncedListeners();
        }
```
5. Реализовать методы
```
    public function getRouteKey(): string;
    public function getSyncedAttributes(): array;
```
где RouteKey должен определить название назначение сущности(название),
    SyncedAttributes должне вернуть массив данных передаваемый для обмена
