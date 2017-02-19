<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%transaction}}".
 *
 * @property integer $id
 * @property integer $manager_id
 * @property integer $user_id
 * @property integer $type
 * @property string $value
 * @property string $comment
 * @property integer $status
 * @property integer $created_at
 *
 * @property User $manager
 * @property User $user
 */
class Transaction extends \yii\db\ActiveRecord
{
    // redefined methods

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%transaction}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['manager_id', 'user_id', 'type', 'value', 'comment', 'status',], 'required'],
            [['manager_id', 'user_id', 'type', 'status', 'created_at'], 'integer'],
            [['value'], 'number'],
            [['comment'], 'string'],
            [['created_at'], 'safe'],
            [
                ['value'],
                function ($attribute, $params) {
                    $sum = self::find()->andWhere(['type' => $this->type])->sum('value');
                    if ( ($sum?:0) + floatval($this->value) < 0) {
                        $this->addError(
                            $attribute,
                            Yii::t(
                                'common/model_labels',
                                'Not enough funds "{attributeName}" for operation',
                                [
                                    'attributeName' => $this->getTypeName()
                                ]
                            )
                        );
                    }
                },
                //'clientValidate' => 'function (attribute, value) {return ;}',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common/model_labels', 'ID'),
            'manager_id' => Yii::t('common/model_labels', 'Manager ID'),
            'user_id' => Yii::t('common/model_labels', 'User ID'),
            'type' => Yii::t('common/model_labels', 'Type'),
            'value' => Yii::t('common/model_labels', 'Value'),
            'comment' => Yii::t('common/model_labels', 'Comment'),
            'status' => Yii::t('common/model_labels', 'Status'),
            'created_at' => Yii::t('common/model_labels', 'Created at'),
        ];
    }

    // relations

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(User::className(), ['id' => 'manager_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    // custom methods

    /**
     * @return array
     */
    public static function getTypeKeyList()
    {
        return [
            'balance',
            'bonus',
        ];
    }

    /**
     * @return array
     */
    public static function getTypeList()
    {
        return [
            Yii::t('common/model_labels', 'Balance'),
            Yii::t('common/model_labels', 'Bonus'),
        ];
    }

    /**
     * @return string
     */
    public function getTypeName()
    {
        return self::getTypeList()[$this->type];
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function getTypeNameByKey($key)
    {
        return self::getTypeList()[array_flip(self::getTypeKeyList())[$key]];
    }

    /**
     * @return array
     */
    public static function getStatusList()
    {
        return [
            Yii::t('common/model_labels', 'Success'),
            Yii::t('common/model_labels', 'Reject'),
        ];
    }

    /**
     * @return string
     */
    public function getStatusName()
    {
        return self::getStatusList()[$this->status];
    }
}
