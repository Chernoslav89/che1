<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%promotion}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $cover
 * @property string $content
 * @property string $type
 * @property integer $published
 * @property string $published_start
 * @property string $published_end
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property City $city
 */
class Promotion extends \yii\db\ActiveRecord
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
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%promotion}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'cover', 'content', 'published'], 'required'],
            [['content'], 'string'],
            [['type', 'published', 'created_at', 'updated_at'], 'integer'],
            [['published_start', 'published_end', 'created_at', 'updated_at'], 'safe'],
            [['title', 'cover'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common/model_labels', 'ID'),
            'title' => Yii::t('common/model_labels', 'Title'),
            'cover' => Yii::t('common/model_labels', 'Cover'),
            'content' => Yii::t('common/model_labels', 'Content'),
            'type' => Yii::t('common/model_labels', 'Type'),
            'published' => Yii::t('common/model_labels', 'Published'),
            'published_start' => Yii::t('common/model_labels', 'Published Start'),
            'published_end' => Yii::t('common/model_labels', 'Published End'),
            'created_at' => Yii::t('common/model_labels', 'Created at'),
            'updated_at' => Yii::t('common/model_labels', 'Updated at'),
        ];
    }

    // relations


    // custom methods

    /**
     * @return array
     */
    public static function getTypeList()
    {
        return [
            Yii::t('common/model_labels', 'Promotion'),
            Yii::t('common/model_labels', 'Event'),
        ];
    }

    /**
     * @return string
     */
    public function getTypeName()
    {
        return self::getTypeList()[$this->type];
    }
}
