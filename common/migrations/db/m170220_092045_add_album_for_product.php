<?php
use yii\db\Schema;
use yii\db\Migration;

class m170220_092045_add_album_for_product extends Migration
{
    public function up()
    {
        // album
        $this->createTable('{{%album}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . ' NOT NULL',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

    }

    public function down()
    {
        // album
        $this->dropTable('{{%album}}');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
