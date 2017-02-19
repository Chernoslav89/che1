<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yz\shoppingcart\CartPositionInterface;


/**
 * This is the model class for table "{{%shop_product}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $price
 *
 * @property AttributeValue[] $attributeValues
 * @property OrderItem[] $orderItems
 * @property Category[] $categories
 * @property GalleryImage[] $images
 */
class Product extends \yii\db\ActiveRecord implements CartPositionInterface
{
    use \yz\shoppingcart\CartPositionTrait;

    private $_categories = null;

    // redefined methods

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \cornernote\linkall\LinkAllBehavior::className(),
            'galleryBehavior' => GalleryImage::getBehaviorConfig([
                'type' => self::className(),
                'directory' => Yii::getAlias('@frontend/web/images/product'),
                'url' => Yii::getAlias('@frontendUrl/images/product'),
            ]),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['categories'], 'safe'],
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
            'description' => Yii::t('common/model_labels', 'Description'),
            'price' => Yii::t('common/model_labels', 'Price'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if (isset($this->_categories)) {
            $this->unlinkAll('categories', true);
            $this->linkAll('categories', Category::findAll($this->_categories));
        }
    }

    /**
     * @inheritdoc
     */
    public function fields()
    {
        return ArrayHelper::merge(
            parent::fields(),
            [
                'images' => function () {
                    return $this->images;
                },
                'attributeValues' => function () {
                    return $this->getAttributeValues()->indexBy('id')->all();
                },
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function extraFields(){
        return ArrayHelper::merge(
            parent::extraFields(),
            [
                'categories' => function () {
                    return $this->getCategories()->indexBy('id')->all();
                },
            ]
        );
    }

    // relations

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeValues()
    {
        return $this->hasMany(AttributeValue::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable('{{%shop_product_to_category}}', ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(GalleryImage::className(), ['ownerId' => 'id'])->andWhere(['type' => self::className(),]);
    }

    // for CartPositionInterface

    public function getPrice()
    {
        return $this->price;
    }

    public function getId()
    {
        return $this->id;
    }

    // custom methods

    /**
     * @param $value
     */
    public function setCategories($value)
    {
        $this->_categories = $value;
    }

    /**
     * @return GalleryImage|string
     */
    public function getImage(){
        $output = Yii::getAlias('@frontendUrl/img/no_image.png');
        if(is_array($this->images)){
            /** @var GalleryImage $image */
            $image = array_shift($this->images);
            if(is_a($image, GalleryImage::className())){
                $output = $image->getPreview();
            }
        }
        return $output;
    }

    // filter

    /**
     * @param array $parameters
     * @return $this
     */
    public static function getFilter($parameters = [])
    {
        // custom params
        $param = [];
        $test_obj = (new self);
        $query = self::find()->indexBy('id');
        $parameters = is_array($parameters) ? array_diff($parameters, ['']) : null;
        if (!empty($parameters)) {
            foreach ($parameters as $key => $value) {
                if ($value == '') continue;
                $table = self::tableName();
                list($column, $relation) = explode('-', $key, 2);
                $relation = str_replace('-', '.', $relation);
                if (!empty($relation)) {
                    $relation_obj = $test_obj->getRelation($relation, false);
                    if ($relation_obj !== null) {
                        /** @var ActiveRecord $modelClass */
                        $modelClass = $relation_obj->modelClass;
                        $table = $modelClass::tableName();
                        $query->joinWith($relation);
                    } else {
                        continue;
                    }
                }
                $rel_column = $table . '.' . $column;
                switch ($key) {
                    case 'q':
                        $words = preg_split('/[\s,.]+/', $value, null, PREG_SPLIT_NO_EMPTY);
                        $query->andWhere([
                            'or',
                            ['like', $table . '.' . 'name', $words],
                            ['like', $table . '.' . 'description', $words]
                        ]);
                        break;
                    case 'price':
                        if (is_array($value)) {
                            if (isset($value['from'], $value['to'])) {
                                $query->andWhere(['between', $rel_column, $value['from'], $value['to']]);
                            } elseif (isset($value['from'])) {
                                $query->andWhere(['>', $rel_column, $value['from']]);
                            } elseif (isset($value['to'])) {
                                $query->andWhere(['<', $rel_column, $value['to']]);
                            }
                        } elseif (is_numeric($value)) {
                            $query->andFilterWhere([$rel_column => $value]);
                        }
                        break;
                    /*/
                    case 1:
                        $query->andWhere(['in', $rel_column, $value]);
                        break;
                    /**/
                    default:
                        $query->andFilterWhere([$rel_column => $value]);
                }
            }
            $query->addParams($param);
        }
        return $query;
    }

}
