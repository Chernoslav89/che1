<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%shop_attribute_value}}".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $attribute_id
 * @property string $value
 *
 * @property Attribute $productAttribute
 * @property Product $product
 */
class AttributeValue extends \yii\db\ActiveRecord
{
    // redefined methods

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_attribute_value}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'attribute_id'], 'integer'],
            //[['value'], 'required'],
            [['value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common/model_labels', 'ID'),
            'product_id' => Yii::t('common/model_labels', 'Product ID'),
            'attribute_id' => Yii::t('common/model_labels', 'Attribute ID'),
            'value' => Yii::t('common/model_labels', 'Value'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function fields(){
        return ArrayHelper::merge(
            parent::fields(),
            [
                'name' => function () {
                    return $this->productAttribute->name;
                },
            ]
        );
    }

    // relations

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttribute()
    {
        return $this->hasOne(Attribute::className(), ['id' => 'attribute_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
