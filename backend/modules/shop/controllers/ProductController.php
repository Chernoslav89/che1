<?php

namespace backend\modules\shop\controllers;

use backend\components\BackendCrudController;
use Yii;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends BackendCrudController
{
    public $search_model = '\common\models\search\ProductSearch';
    public $model = '\common\models\Product';

    public $index_view = '//_partial/index';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $output = parent::behaviors();
        //$output['verbs']['actions']['logout'] = ['post'];

        return $output;
    }

    // custom methods

    /**
     * @inheritdoc
     */
    public function getActionTitleList()
    {
        return [
            'index' => Yii::t('common/model_labels', 'Products')
        ];
    }
}
