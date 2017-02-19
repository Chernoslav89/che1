<?php

namespace common\models;

use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Yii;
use yii\helpers\ArrayHelper;
use zxbodya\yii2\galleryManager\GalleryBehavior;

/**
 * This is the model class for table "{{%gallery_image}}".
 *
 * @property integer $id
 * @property string $type
 * @property string $ownerId
 * @property integer $rank
 * @property string $name
 * @property string $description
 */
class GalleryImage extends \yii\db\ActiveRecord
{
    private $_href;
    private $_preview;

    // redefined methods

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gallery_image}}';
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        $fields = parent::fields();
        $fields['href'] = function () {
            return $this->getHref();
        };
        $fields['preview'] = function () {
            return $this->getPreview();
        };
        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ownerId'], 'required'],
            [['rank'], 'integer'],
            [['description'], 'string'],
            [['type', 'ownerId', 'name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common/model_labels', 'ID'),
            'type' => Yii::t('common/model_labels', 'Type'),
            'ownerId' => Yii::t('common/model_labels', 'Owner ID'),
            'rank' => Yii::t('common/model_labels', 'Rank'),
            'name' => Yii::t('common/model_labels', 'Name'),
            'description' => Yii::t('common/model_labels', 'Description'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->_href = $this->owner->getBehavior('galleryBehavior')->getUrl($this->id);
        $this->_preview = $this->owner->getBehavior('galleryBehavior')->getUrl($this->id, 'preview');
    }

    // relations

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne($this->type, ['id' => 'ownerId']);
    }

    // custom methods

    /**
     * @return mixed
     */
    public function getHref()
    {
        return $this->_href;
    }

    /**
     * @return mixed
     */
    public function getPreview()
    {
        return $this->_preview;
    }

    /**
     * @param array $config
     * @return array
     */
    public static function getBehaviorConfig(array $config)
    {
        return ArrayHelper::merge(
            [
                'class' => GalleryBehavior::className(),
                'extension' => 'png',
                'directory' => Yii::getAlias('@frontend/web/images'),
                'url' => Yii::getAlias('@frontendUrl/images'),
                'versions' => [
                    'preview' => function ($img) {
                        /** @var ImageInterface $img */
                        $size = new Box(200, 200);
                        $img = $img
                            ->copy()
                            ->thumbnail($size, ImageInterface::THUMBNAIL_INSET);
                        /**/
                        return $img;
                        /*/
                        // create transparent thumb
                        $tsize = $img->getSize();
                        $x = $y = 0;
                        if ($size->getWidth() > $tsize->getWidth()) {
                            $x =  round(($size->getWidth() - $tsize->getWidth()) / 2);
                        } elseif ($size->getHeight() > $tsize->getHeight()) {
                            $y = round(($size->getHeight() - $tsize->getHeight()) / 2);
                        }
                        $pasteto = new \Imagine\Image\Point($x, $y);
                        $imagine = new \Imagine\Gd\Imagine();
                        $color = new \Imagine\Image\Color('#000', 100);
                        $image = $imagine->create($size, $color);

                        $image->paste($img, $pasteto);
                        return $image;
                        /**/
                    }
                ]
            ],
            $config
        );
    }
}
