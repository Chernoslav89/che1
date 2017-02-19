<?php

namespace backend\modules\shop\controllers;

use backend\components\BackendCrudController;
use Yii;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends BackendCrudController
{
    public $search_model = '\common\models\search\CategorySearch';
    public $model = '\common\models\Category';

    public $index_view = '//_partial/index';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $output = parent::behaviors();
        //$output['verbs']['actions']['logout'] = ['post'];
        $output['access']['rules'] = [
            [
                'allow' => true,
                'roles' => ['manager'],
            ],
            [
                'allow' => false,
            ],
        ];
        return $output;
    }

    // custom methods

    /**
     * @inheritdoc
     */
    public function getActionTitleList()
    {
        return [
            'index' => Yii::t('common/model_labels', 'Categories')
        ];
    }
}
