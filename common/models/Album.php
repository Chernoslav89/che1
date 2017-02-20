<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%album}}".
 *
 * @property integer $id
 * @property integer $city_id
 * @property string $name
 * @property integer $created_at
 *
 * @property City $city
 */
class Album extends \yii\db\ActiveRecord
{

    // redefined methods

    public function fields()
    {
        $fields = parent::fields();
        $fields['images'] = function () {
            return $this->images;
        };
        return $fields;
    }

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
            'galleryBehavior' => GalleryImage::getBehaviorConfig([
                'type' => self::className(),
                'directory' => Yii::getAlias('@frontend/web/images/album'),
                'url' => Yii::getAlias('@frontendUrl/images/album'),
            ]),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%album}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['city_id'], 'integer'],
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
            'city_id' => Yii::t('common/model_labels', 'City ID'),
            'name' => Yii::t('common/model_labels', 'Name'),
            'created_at' => Yii::t('common/model_labels', 'Created at'),
        ];
    }

    // relations

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(GalleryImage::className(), ['ownerId' => 'id'])->andWhere(['type' => self::className(),]);
    }
}
