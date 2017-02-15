
`administrator` role account
```
Login: webmaster
Password: webmaster
```

`manager` role account
```
Login: manager
Password: manager
```

`user` role account
```
Login: user
Password: user
```

# Application Components

### I18N
If you want to store application messages in DB and to have ability to edit them from backend, run:
```
php console/yii message/migrate @common/config/messages/php.php @common/config/messages/db.php
```
it will copy all existing messages to database

Then uncomment config for `DbMessageSource` in
```php
common/config/base.php
```

### KeyStorage
Key storage is a key-value storage to store different information. Application settings for example.
Values can be stored both via api or by backend CRUD component.
```
Yii::$app->keyStorage->set('articles-per-page', 20);
Yii::$app->keyStorage->get('articles-per-page'); // 20
```

### Maintenance mode
Project has built-in component to provide a maintenance functionality. All you have to do is to configure ``maintenance``
component in your config
```php
'bootstrap' => ['maintenance'],
...
'components' => [
    ...
    'maintenance' => [
        'class' => 'common\components\maintenance\Maintenance',
        'enabled' => Astronomy::isAFullMoonToday()
    ]
    ...
]
```
This component will catch all incoming requests, set proper response HTTP headers (503, "Retry After") and show a maintenance message.
Additional configuration options can be found in a corresponding class.

Project configured to turn on maintenance mode if ``frontend.maintenance`` key in KeyStorage is set to ``true``

### Command Bus
- [What is command bus?](http://shawnmc.cool/command-bus)

In Project Command Bus pattern is implemented with [tactician](https://github.com/thephpleague/tactician) package and 
it's yii2 connector - [yii2-tactician](https://github.com/trntv/yii2-tactician)

Command are stored in ``common/commands/command`` directory, handlers in ``common/commands/handler``

To execute command run
```php
$sendEmailCommand = new SendEmailCommand(['to' => 'user@example.org', 'body' => 'Hello User!']);
Yii::$app->commandBus->handle($sendEmailCommand);
```

### Timeline (Activity)
```php
$addToTimelineCommand = new AddToTimelineCommand([
    'category' => 'user', 
    'event' => 'signup', 
    'data' => ['foo' => 'bar']
]);
Yii::$app->commandBus->handle($addToTimelineCommand);
```

### Behaviors
#### CacheInvalidateBehavior
```php
 public function behaviors()
 {
     return [
         [
             'class' => `common\behaviors\CacheInvalidateBehavior`,
             'tags' => [
                  'awesomeTag',
                   function($model){
                       return "tag-{$model->id}"
                  }
              ],
             'keys' => [
                  'awesomeKey',
                  function($model){
                      return "key-{$model->id}"
                  }
              ]
         ],
     ];
 }
```
#### GlobalAccessBehavior
Add in your application config:
```php
'as globalAccess'=>[
        'class'=>'\common\behaviors\GlobalAccessBehavior',
        'rules'=>[
            [
                'controllers'=>['sign-in'],
                'allow' => true,
                'roles' => ['?'],
                'actions'=>['login']
            ],
            [
                'controllers'=>['sign-in'],
                'allow' => true,
                'roles' => ['@'],
                'actions'=>['logout']
            ],
            [
                'controllers'=>['site'],
                'allow' => true,
                'roles' => ['?', '@'],
                'actions'=>['error']
            ],
            [
				'allow' => true,
				'roles' => ['@']
			]
        ]
    ]
```
It will allow access to you application only for authentificated users. 

### Command Bus
Read more about command bus on in [official repository](https://github.com/trntv/yii2-command-bus#yii2-command-bus)

### Widgets configurable from backend
#### Carousel
1. Create carousel in backend
2. Use it:
```php
<?php echo DbCarousel::widget(['key' => 'key-from-backend']) ?>
```

#### DbText
1. Create text block in backend
2. Use it:
```php
<?php echo DbText::widget(['key' => 'key-from-backend']) ?>
```

#### DbMenu
1. Create text block in backend
2. Use it:
```php
<?php echo DbMenu::widget(['key' => 'key-from-backend']) ?>
```

### Widgets
- [WYSIWYG Redactor widget](https://github.com/asofter/yii2-imperavi-redactor)  
- [DateTime picker](https://github.com/trntv/yii2-bootstrap-datetimepicker)
- [Ace Editor](https://github.com/trntv/yii2-aceeditor)
- [File upload](https://github.com/trntv/yii2-file-kit)
- [ElFinder](https://github.com/MihailDev/yii2-elfinder)


### Grid
#### EnumColumn
```php
 [
      'class' => '\common\grid\EnumColumn',
      'attribute' => 'status',
      'enum' => User::getStatuses() // [0=>'Deleted', 1=>'Active']
 ]
```
### API
Project has fully configured and ready-to-go REST API module. You can access it on http://localhost.dev/api/v1
For some endpoints you should authenticate your requests with one of available methods - https://github.com/yiisoft/yii2/blob/master/docs/guide/rest-authentication.md#authentication

### MultiModel
``common\base\MultiModel`` - class for handling multiple models in one
In controller:
```php
$model = new MultiModel([
    'models' => [
        'user' => $userModel,
        'profile' => $userProfileModel
    ]
]);

if ($model->load(Yii::$app->request->post()) && $model->save()) {
    ...
}
```
In view:
```php
<?php echo $form->field($model->getModel('account'), 'username') ?>

<?php echo $form->field($model->getModel('profile'), 'middlename')->textInput(['maxlength' => 255]) ?>    
```
### Other
- ``common\behaviors\GlobalAccessBehavior`` - allows to set access rules for your application in application config

- ``common\behaviors\LocaleBehavior`` - discover user locale from browser or account settings and set it

- ``common\behaviors\LoginTimestampBehavior`` - logs user login time

- ``common\validators\JsonValidator`` - validates a value to be a valid json

- ``common\rbac\rule\OwnModelRule`` - simple rule for RBAC to check if the current user is model owner
```php
Yii::$app->user->can('editOwnModel', ['model' => $model]);
```

- ``common\filters\OwnModelAccessFilter`` - action filter to check if user is allowed to manage this model
```php
public function behaviors()
    {
        return [
            'modelAccess' => [
                'class' => OwnModelAccessFilter::className(),
                'only' => ['view', 'update', 'delete'],
                'modelCreatedByAttribute' => 'created_by',
                'modelClass' => Article::className()
            ],
        ];
    }
```
