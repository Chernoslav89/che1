<?php

use common\models\User;
use yii\db\Migration;

class m150725_192740_seed_data extends Migration
{
    public function safeUp()
    {
        $this->insert('{{%user}}', [
            'id' => 1,
            'username' => 'webmaster',
            'email' => 'webmaster@example.com',
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('webmaster'),
            'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
            'access_token' => Yii::$app->getSecurity()->generateRandomString(40),
            'status' => User::STATUS_ACTIVE,
            'created_at' => time(),
            'updated_at' => time()
        ]);
        $this->insert('{{%user}}', [
            'id' => 2,
            'username' => 'manager',
            'email' => 'manager@example.com',
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('manager'),
            'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
            'access_token' => Yii::$app->getSecurity()->generateRandomString(40),
            'status'=> User::STATUS_ACTIVE,
            'created_at' => time(),
            'updated_at' => time()
        ]);
        $this->insert('{{%user}}', [
            'id' => 3,
            'username' => 'user',
            'email' => 'user@example.com',
            'password_hash' => Yii::$app->getSecurity()->generatePasswordHash('user'),
            'auth_key' => Yii::$app->getSecurity()->generateRandomString(),
            'access_token' => Yii::$app->getSecurity()->generateRandomString(40),
            'status' => User::STATUS_ACTIVE,
            'created_at' => time(),
            'updated_at' => time()
        ]);

        $this->insert('{{%user_profile}}', [
            'user_id'=>1,
            'locale'=>Yii::$app->sourceLanguage,
            'firstname' => 'John',
            'lastname' => 'Doe'
        ]);
        $this->insert('{{%user_profile}}', [
            'user_id'=>2,
            'locale'=>Yii::$app->sourceLanguage
        ]);
        $this->insert('{{%user_profile}}', [
            'user_id'=>3,
            'locale'=>Yii::$app->sourceLanguage
        ]);

        $this->insert('{{%page}}', [
            'slug' => 'about',
            'title' => 'About',
            'body' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'status' => \common\models\Page::STATUS_PUBLISHED,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%article_category}}', [
            'id' => 1,
            'slug' => 'news',
            'title' => 'News',
            'status' => \common\models\ArticleCategory::STATUS_ACTIVE,
            'created_at' => time()
        ]);

        $this->insert('{{%widget_menu}}', [
            'key'=>'frontend-index',
            'title'=>'Frontend index menu',
            'items'=>json_encode([
                [
                    'label'=>'test',
                    'url'=>'http://calambur-shop.dev/',
                    'options'=>['tag'=>'span'],
                    'template'=>'<a href="{url}" class="btn btn-lg btn-success">{label}</a>'
                ]
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'status'=>\common\models\WidgetMenu::STATUS_ACTIVE
        ]);

        $this->insert('{{%widget_text}}', [
            'key'=>'backend_welcome',
            'title'=>'Welcome to backend',
            'body'=>'<p>Welcome to Yii2 Starter Kit Dashboard</p>',
            'status'=>1,
            'created_at'=> time(),
            'updated_at'=> time(),
        ]);


        $this->insert('{{%widget_carousel}}', [
            'id'=>1,
            'key'=>'index',
            'status'=>\common\models\WidgetCarousel::STATUS_ACTIVE
        ]);

        $this->insert('{{%widget_carousel_item}}', [
            'carousel_id'=>1,
            'base_url' => Yii::getAlias('@frontendUrl'),
            'path'=>'img/DSC_5371.jpeg',
            'type'=>'image/jpeg',
            'url'=>'/',
            'status'=>1
        ]);

        $this->insert('{{%key_storage_item}}', [
            'key' => 'backend.theme-skin',
            'value' => 'skin-blue',
            'comment' => 'skin-blue, skin-black, skin-purple, skin-green, skin-red, skin-yellow'
        ]);

        $this->insert('{{%key_storage_item}}', [
            'key' => 'backend.layout-fixed',
            'value' => 0
        ]);

        $this->insert('{{%key_storage_item}}', [
            'key' => 'backend.layout-boxed',
            'value' => 0
        ]);

        $this->insert('{{%key_storage_item}}', [
            'key' => 'backend.layout-collapsed-sidebar',
            'value' => 0
        ]);

        $this->insert('{{%key_storage_item}}', [
            'key' => 'frontend.maintenance',
            'value' => 'disabled',
            'comment' => 'Set it to "true" to turn on maintenance mode'
        ]);

    }

    public function safeDown()
    {
        $this->delete('{{%key_storage_item}}', [
            'key' => 'frontend.maintenance'
        ]);

        $this->delete('{{%key_storage_item}}', [
            'key' => [
                'backend.theme-skin',
                'backend.layout-fixed',
                'backend.layout-boxed',
                'backend.layout-collapsed-sidebar',
            ],
        ]);

        $this->delete('{{%widget_carousel_item}}', [
            'carousel_id'=>1
        ]);

        $this->delete('{{%widget_carousel}}', [
            'id'=>1
        ]);

        $this->delete('{{%widget_text}}', [
            'key'=>'backend_welcome'
        ]);

        $this->delete('{{%widget_menu}}', [
            'key'=>'frontend-index'
        ]);

        $this->delete('{{%article_category}}', [
            'id' => 1
        ]);

        $this->delete('{{%page}}', [
            'slug' => 'about'
        ]);

        $this->delete('{{%user_profile}}', [
            'user_id' => [1, 2, 3]
        ]);

        $this->delete('{{%user}}', [
            'id' => [1, 2, 3]
        ]);
    }
}
