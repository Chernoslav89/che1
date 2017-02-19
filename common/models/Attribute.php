<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%shop_attribute}}".
 *
 * @property integer $id
 * @property string $name
 *
 * @property AttributeValue[] $attributeValues
 */
class Attribute extends \yii\db\ActiveRecord
{
    // redefined methods

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_attribute}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common/model_labels', 'ID'),
            'name' => Yii::t('common/model_labels', 'Name'),
        ];
    }

    // relations

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeValues()
    {
        return $this->hasMany(AttributeValue::className(), ['attribute_id' => 'id']);
    }
}
