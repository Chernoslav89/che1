<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%shop_category_path}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $path_id
 * @property integer $level
 *
 * @property Category $path
 * @property Category $category
 */
class CategoryPath extends \yii\db\ActiveRecord
{
    // redefined methods

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shop_category_path}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'path_id', 'level'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common/model_labels', 'ID'),
            'category_id' => Yii::t('common/model_labels', 'Category ID'),
            'path_id' => Yii::t('common/model_labels', 'Path ID'),
            'level' => Yii::t('common/model_labels', 'Level'),
        ];
    }

    // relations

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPath()
    {
        return $this->hasOne(Category::className(), ['id' => 'path_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
}
