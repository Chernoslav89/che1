<?php

namespace backend\modules\shop\controllers;

use backend\components\BackendCrudController;
use Yii;
use yii\web\Response;

/**
 * AttributeController implements the CRUD actions for Attribute model.
 */
class AttributeController extends BackendCrudController
{
    public $search_model = '\common\models\search\AttributeSearch';
    public $model = '\common\models\Attribute';

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
            'index' => Yii::t('common/model_labels', 'Attributes')
        ];
    }
}
