<?php

namespace backend\modules\shop\controllers;

use backend\components\BackendCrudController;
use common\models\Product;
use Yii;
use yii\helpers\Json;
use yii\web\HttpException;

/**
 * AttributeValueController implements the CRUD actions for AttributeValue model.
 */
class AttributeValueController extends BackendCrudController
{
    public $search_model = '\common\models\search\AttributeValueSearch';
    public $model = '\common\models\AttributeValue';

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

    /**
     * Creates a new AttributeValue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $product_id integer
     * @return string|\yii\web\Response
     * @throws HttpException
     */
    public function actionCreate()
    {
        $product_id = Yii::$app->request->get('product_id');
        $product = Product::findOne($product_id);
        if (!$product) {
            throw new HttpException(400);
        }
        /** @var \common\models\AttributeValue $model */
        $model = new $this->model(['product_id' => $product_id]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['product/update', 'id' => $product_id]);
        } else {
            return $this->render($this->create_view, [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AttributeValue model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $product_id = Yii::$app->request->get('product_id');
        $model = $this->findModel($id);
        if (Yii::$app->request->post('hasEditable')) {
            $model->load(Yii::$app->request->post($model->formName())[Yii::$app->request->post('editableIndex')], '');
            $dirtyAttribute = array_keys($model->dirtyAttributes)[0];
            $model->save();
            return  Json::encode([
                'output' => $dirtyAttribute === 'value'?
                    $model->{$dirtyAttribute}:
                    $model->productAttribute->name,
                'message'=>''
            ]);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['product/update', 'id' => $product_id]);
        } else {
            return $this->render($this->update_view, [
                'model' => $model,
            ]);
        }
    }

    // custom methods

    /**
     * @inheritdoc
     */
    public function getActionTitleList()
    {
        return [
            'index' => Yii::t('common/model_labels', 'Attribute values')
        ];
    }
}
