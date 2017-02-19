<?php

use yii\db\Migration;

class m170219_112816_add_shop_tables extends Migration
{
    public function safeUp()
    {
        $tableOptions = $this->db->driverName === 'mysql' ? 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB' : null;
        // product
        $this->createTable('{{%shop_product}}', [
            'id'                    => $this->primaryKey(),
            'name'                  => $this->string()->notNull(),
            'description'           => $this->text(),
            'price'                 => $this->money()->notNull()->defaultValue(0),
        ], $tableOptions);
        // product_attribute
        $this->createTable('{{%shop_attribute}}', [
            'id'                    => $this->primaryKey(),
            'name'                  => $this->string()->notNull(),
        ], $tableOptions);
        // product_attribute_value
        $this->createTable('{{%shop_attribute_value}}', [
            'id'                    => $this->primaryKey(),
            'product_id'            => $this->integer(),
            'attribute_id'          => $this->integer(),
            'value'                 => $this->string()->notNull(),
        ], $tableOptions);
        $this->addForeignKey('fk_product_attribute_value_2_product',
            '{{%shop_attribute_value}}', 'product_id',
            '{{%shop_product}}', 'id',
            'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_product_attribute_value_2_product_attribute',
            '{{%shop_attribute_value}}', 'attribute_id',
            '{{%shop_attribute}}', 'id',
            'CASCADE', 'CASCADE');
        // category
        $this->createTable('{{%shop_category}}', [
            'id'                    => $this->primaryKey(),
            'name'                  => $this->string()->notNull(),
            'cover'                 => $this->string()->notNull(),
            'description'           => $this->text(),
        ], $tableOptions);
        // category_path
        $this->createTable('{{%shop_category_path}}', [
            'id'                    => $this->primaryKey(),
            'category_id'           => $this->integer(),
            'path_id'               => $this->integer(),
            'level'                 => $this->smallInteger(),
        ], $tableOptions);
        $this->addForeignKey('fk_category_path_2_category',
            '{{%shop_category_path}}', 'category_id',
            '{{%shop_category}}', 'id',
            'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_category_path_2_path',
            '{{%shop_category_path}}', 'path_id',
            '{{%shop_category}}', 'id',
            'CASCADE', 'CASCADE');
        // product_to_category
        $this->createTable('{{%shop_product_to_category}}', [
            'id'                    => $this->primaryKey(),
            'product_id'            => $this->integer(),
            'category_id'           => $this->integer(),
        ], $tableOptions);
        $this->addForeignKey('fk_product_to_category_2_product',
            '{{%shop_product_to_category}}', 'product_id',
            '{{%shop_product}}', 'id',
            'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_product_to_category_2_category',
            '{{%shop_product_to_category}}', 'category_id',
            '{{%shop_category}}', 'id',
            'CASCADE', 'CASCADE');
        // favorites
        $this->createTable('{{%shop_favorites}}', [
            'id'                    => $this->primaryKey(),
            'product_id'            => $this->integer(),
            'user_id'               => $this->integer(),
        ], $tableOptions);
        $this->addForeignKey('fk_favorites_2_product',
            '{{%shop_favorites}}', 'product_id',
            '{{%shop_product}}', 'id',
            'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_favorites_2_user',
            '{{%shop_favorites}}', 'user_id',
            '{{%user}}', 'id',
            'CASCADE', 'CASCADE');
        // order
        $this->createTable('{{%shop_order}}', [
            'id'                    => $this->primaryKey(),
            'user_id'               => $this->integer(),
            'status'                => $this->smallInteger()->notNull(),
            'note'                  => $this->text(),
            'delivery_address'      => $this->text(),
            'fullname'              => $this->string(),
            'tel'                   => $this->string(),
            'email'                 => $this->string(),
            'created_at'            => $this->integer()->notNull(),
            'updated_at'            => $this->integer()->notNull(),
        ], $tableOptions);
        // order_item
        $this->createTable('{{%shop_order_item}}', [
            'id'                    => $this->primaryKey(),
            'order_id'               => $this->integer(),
            'product_id'            => $this->integer(),
            'name'                  => $this->string()->notNull(),
            'description'           => $this->integer(),
            'price'                 => $this->money()->notNull()->defaultValue(0),
            'sale'                  => $this->string(),
        ], $tableOptions);
        $this->addForeignKey('fk_order_item_2_order',
            '{{%shop_order_item}}', 'order_id',
            '{{%shop_order}}', 'id',
            'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_order_item_2_product',
            '{{%shop_order_item}}', 'product_id',
            '{{%shop_product}}', 'id',
            'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        // order_item
        $this->dropForeignKey('fk_order_item_2_product', '{{%shop_order_item}}');
        $this->dropForeignKey('fk_order_item_2_order', '{{%shop_order_item}}');
        $this->dropTable('{{%shop_order_item}}');
        // order
        $this->dropTable('{{%shop_order}}');
        // favorites
        $this->dropForeignKey('fk_favorites_2_user', '{{%shop_favorites}}');
        $this->dropForeignKey('fk_favorites_2_product', '{{%shop_favorites}}');
        $this->dropTable('{{%shop_favorites}}');
        // product_to_category
        $this->dropForeignKey('fk_product_to_category_2_category', '{{%shop_product_to_category}}');
        $this->dropForeignKey('fk_product_to_category_2_product', '{{%shop_product_to_category}}');
        $this->dropTable('{{%shop_product_to_category}}');
        // category_path
        $this->dropForeignKey('fk_category_path_2_path', '{{%shop_category_path}}');
        $this->dropForeignKey('fk_category_path_2_category', '{{%shop_category_path}}');
        $this->dropTable('{{%shop_category_path}}');
        // category
        $this->dropTable('{{%shop_category}}');
        // product_attribute_value
        $this->dropForeignKey('fk_product_attribute_value_2_product', '{{%shop_attribute_value}}');
        $this->dropForeignKey('fk_product_attribute_value_2_product_attribute', '{{%shop_attribute_value}}');
        $this->dropTable('{{%shop_attribute_value}}');
        // product_attribute
        $this->dropTable('{{%shop_attribute}}');
        // product
        $this->dropTable('{{%shop_product}}');
    }
}
