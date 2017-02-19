<?php

use yii\db\Schema;
use yii\db\Migration;

class m170219_134001_add_quantity_col_to_order_item_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%shop_order_item}}', 'quantity', Schema::TYPE_INTEGER . ' NOT NULL AFTER description');
        $this->alterColumn('{{%shop_order_item}}', 'description', Schema::TYPE_TEXT);
    }

    public function down()
    {
        $this->alterColumn('{{%shop_order_item}}', 'description', Schema::TYPE_INTEGER);
        $this->dropColumn('{{%shop_order_item}}', 'quantity');
    }
}
