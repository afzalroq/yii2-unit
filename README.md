# yii2-unit extension

The extension allows manage block of html contents, files, images.

### Installation

- Install with composer:

```bash
composer require afzalroq/yii2-unit "^1.1"
```

- **After composer install** run console command for create tables:

```bash
php yii migrate/up --migrationPath=@vendor/afzalroq/yii2-unit/migrations
```

- Setup in common config storage and language configurations.
> language indexes related with database columns.

> Admin panel tabs render by array values order. 

> Begin id param value from 0.
```php
'modules' => [
    'unit' => [ // don`t change module key
        'class' => '@afzalroq\unit\Module',
        'storageRoot' => $params['staticPath'],
        'storageHost' => $params['staticHostInfo'],
        'thumbs' => [ // 'sm' and 'md' keys are reserved
            'admin' => ['width' => 128, 'height' => 128],
            'thumb' => ['width' => 320, 'height' => 320],
        ],
        'languages' => [
            'ru' => [
                'id' => 0,
                'name' => 'Русский',
            ],
            'uz' => [
                'id' => 1,
                'name' => 'English',
            ],
        ],
    ],
]
```

- In admin panel add belove links for manage categories and blocks:
```php
/unit/categories/index
/unit/units/index?slug=your_category_slug_name
```

> For using BlockController actions you must manual specify their category slug in route.

###Examples

Extension registers next language arrays to Yii::$app->params[] for use in views:
```php
\Yii::$app->params['cms']['languageIds'][$prefix] = $language['id'];
[
    'en' => 2,
    'ru' => 1,
    ...
]

\Yii::$app->params['cms']['languages'][$prefix] = $language['name'];
[
    'en' => 'English',
    ...
]


\Yii::$app->params['cms']['languages2'][$language['id']] = $language['name'];
[
    2 => 'English',
    ...
]
```

###Frontend widgets integration

> get all blocks by category slug
```
afzalroq\unit\entities\Unit::getBySlug($slug)

```

> get each block data for current app language:
```
$units = Unit::getBySlug($slug);
foreach ($units as $unit) {
    echo ($blockObject->getModelByType())->get();
}

```

---

> TODO 
 - Copy from extension root directory example widgets for frontend integration  
