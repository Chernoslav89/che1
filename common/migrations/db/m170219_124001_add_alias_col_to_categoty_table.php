<?php

use yii\db\Schema;
use yii\db\Migration;

class m170219_124001_add_alias_col_to_categoty_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%shop_category}}', 'alias', Schema::TYPE_TEXT . ' NOT NULL AFTER name');
    }

    public function down()
    {
        $this->dropColumn('{{%shop_category}}', 'alias');
    }
}
