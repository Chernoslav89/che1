<?php

namespace backend\modules\shop\controllers;

use backend\components\BackendController;

class DefaultController extends BackendController
{
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

    public function actionIndex()
    {
        return $this->render('index');
    }
}
