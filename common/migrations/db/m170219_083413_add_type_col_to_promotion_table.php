<?php

use yii\db\Schema;
use yii\db\Migration;

class m170219_083413_add_type_col_to_promotion_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%promotion}}', 'type', Schema::TYPE_SMALLINT . ' NOT NULL AFTER content');
    }

    public function down()
    {
        $this->dropColumn('{{%promotion}}', 'type');
    }
}
