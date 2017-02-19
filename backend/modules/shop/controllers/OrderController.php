<?php

namespace backend\modules\shop\controllers;

use backend\components\BackendCrudController;
use Yii;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends BackendCrudController
{
    public $search_model = '\common\models\search\OrderSearch';
    public $model = '\common\models\Order';

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
            'index' => Yii::t('common/model_labels', 'Orders')
        ];
    }
}
