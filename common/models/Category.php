<?php

namespace common\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use yii\db\Expression;
use yii\db\Query;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%shop_category}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $name
 * @property string $cover
 * @property string $description
 *
 * @property CategoryPath[] $categories
 * @property City[] $city
 * @property CategoryPath[] $paths
 * @property Product[] $products
 * @property Category[] $subCategories
 * @property Category $parent
 */
class Category extends \yii\db\ActiveRecord
{
    // redefined methods

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'alias',
                'immutable' => true,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'cover'], 'required'],
            [['description'], 'string'],
            [['parent_id'], 'integer'],
            [['parent_id'], 'default', 'value' => 0],
            [['name', 'cover'], 'string', 'max' => 255]
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
            'cover' => Yii::t('common/model_labels', 'Cover'),
            'description' => Yii::t('common/model_labels', 'Description'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // MySQL Hierarchical Data Closure Table Pattern
        $query_rows = CategoryPath::find()->andWhere(['path_id' => $this->id])->addOrderBy(['level' => 'ASC'])->all();
        if ($query_rows) {
            foreach ($query_rows as $category_path) {
                /** @var CategoryPath $category_path */
                // Delete the path below the current one
                CategoryPath::deleteAll(['and', ['category_id' => $category_path->category_id], ['<', 'level', $category_path->level],]);
                $path = [];
                // Get the nodes new parents
                $rows = CategoryPath::find()->andWhere(['category_id' => $this->parent_id])->addOrderBy(['level' => 'ASC'])->all();
                foreach ($rows as $result) {
                    $path[] = $result->path_id;
                }
                // Get whats left of the nodes current path
                $rows = CategoryPath::find()->andWhere(['category_id' => $category_path->category_id])->addOrderBy(['level' => 'ASC'])->all();
                foreach ($rows as $result) {
                    $path[] = $result['path_id'];
                }
                // Combine the paths with a new level
                $level = 0;
                foreach ($path as $path_id) {
                    /*
                    $this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category_path['category_id'] . "', `path_id` = '" . (int)$path_id . "', level = '" . (int)$level . "'");
                    */
                    CategoryPath::deleteAll(['path_id' => $path_id, 'category_id' => $category_path->category_id]);
                    (new CategoryPath(['path_id' => $path_id, 'category_id' => $category_path->category_id, 'level' => $level,]))->save();

                    $level++;
                }
            }
        } else {
            // Delete the path below the current one
            CategoryPath::deleteAll(['category_id' => $this->id,]);
            // Fix for records with no paths
            $level = 0;
            $rows = CategoryPath::find()->andWhere(['category_id' => $this->parent_id])->addOrderBy(['level' => 'ASC'])->all();
            foreach ($rows as $result) {
                (new CategoryPath(['category_id' => $this->id, 'path_id' => $result->path_id, 'level' => $level,]))->save();
                $level++;
            }
            /*
            $this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category_id . "', `path_id` = '" . (int)$category_id . "', level = '" . (int)$level . "'");
            */
            CategoryPath::deleteAll(['path_id' => $this->id, 'category_id' => $this->id]);
            (new CategoryPath(['path_id' => $this->id, 'category_id' => $this->id, 'level' => $level,]))->save();
        }
    }

    /**
     * @inheritdoc
     */
    public function extraFields(){
        return ArrayHelper::merge(
            parent::extraFields(),
            [
                'pathString' => function () {
                    return $this->pathString()->scalar();
                },
            ]
        );
    }

    // relations

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(CategoryPath::className(), ['path_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubCategories()
    {
        return $this->hasMany(Category::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaths()
    {
        return $this->hasMany(CategoryPath::className(), ['category_id' => 'id'])
            ->orderBy('level');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'product_id'])
            ->viaTable('{{%shop_product_to_category}}', ['category_id' => 'id']);
    }

    // custom methods

    public function pathString(){
        return $this->getPaths()
            ->joinWith('path')
            ->select(new Expression("GROUP_CONCAT({{%shop_category}}.alias SEPARATOR '/')"))
            ->groupBy('{{%shop_category_path}}.category_id');
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
        $query = self::find();
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
                        /** @var \yii\db\ActiveRecord $modelClass */
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
                            ['like', 'name', $words],
                            ['like', 'description', $words]
                        ]);
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
