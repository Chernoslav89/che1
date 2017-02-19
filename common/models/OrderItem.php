<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%shop_order_item}}".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $product_id
 * @property string $name
 * @property string $description
 * @property integer $quantity
 * @property string $price
 * @property string $sale
 *
 * @property Product $product
 * @property Order $order
 */
class OrderItem extends \yii\db\ActiveRecord
{
    // redefined methods

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_order_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id',], 'integer'],
            [['name'], 'required'],
            [['price'], 'number'],
            [['name', 'sale'], 'string', 'max' => 255],
            [['description'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common/model_labels', 'ID'),
            'order_id' => Yii::t('common/model_labels', 'Order ID'),
            'product_id' => Yii::t('common/model_labels', 'Product ID'),
            'name' => Yii::t('common/model_labels', 'Name'),
            'description' => Yii::t('common/model_labels', 'Description'),
            'price' => Yii::t('common/model_labels', 'Price'),
            'sale' => Yii::t('common/model_labels', 'Sale'),
            'quantity' => Yii::t('common/model_labels', 'Quantity'),
        ];
    }

    // relations

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}
