<?php

use yii\db\Schema;
use yii\db\Migration;

class m170219_082308_update_create_tables extends Migration
{

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        // user
        $this->addColumn('{{%user}}', 'fullname', Schema::TYPE_STRING . ' NOT NULL');
        $this->addColumn('{{%user}}', 'tel', Schema::TYPE_STRING . '(30) NOT NULL');
        $this->addColumn('{{%user}}', 'balance', Schema::TYPE_DECIMAL . ' NOT NULL DEFAULT 0');
        $this->addColumn('{{%user}}', 'bonus', Schema::TYPE_DECIMAL . ' NOT NULL DEFAULT 0');
        $this->addColumn('{{%user}}', 'photo', Schema::TYPE_STRING . ' NOT NULL');

        $this->createTable('{{%promotion}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . ' NOT NULL',
            'cover' => Schema::TYPE_STRING . ' NOT NULL',
            'content' => Schema::TYPE_TEXT . ' NOT NULL',
            'published' => Schema::TYPE_BOOLEAN . ' NOT NULL',
            'published_start' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'published_end' => Schema::TYPE_TIMESTAMP . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        // respond
        $this->createTable('{{%respond}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'thread' => Schema::TYPE_STRING . ' NOT NULL',
            'type' => Schema::TYPE_SMALLINT . ' NOT NULL',
            'comment' => Schema::TYPE_TEXT . ' NOT NULL',

        ], $tableOptions);
        $this->addForeignKey('fk_respond_2_user', '{{%respond}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        // subscribe
        $this->createTable('{{%subscribe}}', [
            'id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'type' => Schema::TYPE_SMALLINT . ' NOT NULL',
            'item' => Schema::TYPE_STRING . ' NOT NULL',

        ], $tableOptions);
        $this->addForeignKey('fk_subscribe_2_user', '{{%subscribe}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        // faq
        $this->createTable('{{%faq}}', [
            'id' => Schema::TYPE_PK,
            'question' => Schema::TYPE_TEXT . ' NOT NULL',
            'answer' => Schema::TYPE_TEXT . ' NOT NULL',

        ], $tableOptions);
        // celebration

        $this->createTable('{{%transaction}}', [
            'id' => Schema::TYPE_PK,
            'manager_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'type' => Schema::TYPE_SMALLINT . ' NOT NULL',
            'value' => Schema::TYPE_DECIMAL . ' NOT NULL',
            'comment' => Schema::TYPE_TEXT . ' NOT NULL',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        $this->addForeignKey('fk_transaction_2_manager', '{{%transaction}}', 'manager_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_transaction_2_user', '{{%transaction}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');

        // photo
        $this->createTable('{{%gallery_image}}', [
            'id' => Schema::TYPE_PK,
            'type' => Schema::TYPE_STRING,
            'ownerId' => Schema::TYPE_STRING . ' NOT NULL',
            'rank' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'name' => Schema::TYPE_STRING,
            'description' => Schema::TYPE_TEXT
        ], $tableOptions);
    }

    public function safeDown()
    {

    }
}
