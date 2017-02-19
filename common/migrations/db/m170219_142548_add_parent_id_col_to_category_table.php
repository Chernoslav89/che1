<?php

use yii\db\Schema;
use yii\db\Migration;

class m170219_142548_add_parent_id_col_to_category_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%shop_category}}', 'parent_id', Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0 AFTER cover');
    }

    public function down()
    {
        $this->dropColumn('{{%shop_category}}', 'parent_id');
    }
}
