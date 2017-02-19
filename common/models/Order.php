<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%shop_order}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $status
 * @property string $note
 * @property string $delivery_address
 * @property string $fullname
 * @property string $tel
 * @property string $email
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property City $city
 * @property OrderItem[] $orderItems
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{
    const SCENARIO_NEW = 'new';

    // redefined methods

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => [
                'class' => '\yii\behaviors\TimestampBehavior',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // SCENARIO_DEFAULT
            [['user_id', 'status', 'created_at', 'updated_at'], 'integer', 'on' => self::SCENARIO_DEFAULT],
            [['tel'], 'required', 'on' => self::SCENARIO_DEFAULT],
            // SCENARIO_NEW
            [['tel',], 'required', 'on' => self::SCENARIO_NEW],
            [['user_id'], 'integer', 'on' => self::SCENARIO_NEW],
            [['fullname', 'tel', 'email', 'note',], 'safe', 'on' => self::SCENARIO_NEW],
            // common
            [['note', 'delivery_address'], 'string'],
            [['email'], 'email'],
            [['fullname', 'tel'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common/model_labels', 'ID'),
            'user_id' => Yii::t('common/model_labels', 'User ID'),
            'status' => Yii::t('common/model_labels', 'Status'),
            'note' => Yii::t('common/model_labels', 'Note'),
            'delivery_address' => Yii::t('common/model_labels', 'Delivery Address'),
            'fullname' => Yii::t('common/model_labels', 'Fullname'),
            'tel' => Yii::t('common/model_labels', 'Tel'),
            'email' => Yii::t('common/model_labels', 'Email'),
            'created_at' => Yii::t('common/model_labels', 'Created at'),
            'updated_at' => Yii::t('common/model_labels', 'Updated at'),
        ];
    }

    // relations

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'id']);
    }

    // custom methods
}
