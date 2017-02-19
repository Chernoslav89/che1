<?php

namespace backend\components;

use Yii;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * BackendController implements the access and verbs for actions.
 */
class BackendCrudController extends BackendController
{

    public $search_model = null;
    public $model = null;

    public $index_view = 'index';
    public $view_view = 'view';
    public $create_view = 'create';
    public $update_view = 'update';

    // actions

    /**
     * Lists all models.
     * @return mixed
     */
    public function actionIndex()
    {
        /**
         * @var \yii\db\ActiveRecord $searchModel
         * @var \yii\data\ActiveDataProvider $dataProvider
         * */
        $searchModel = new $this->search_model();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (Yii::$app->request->isAjax && !Yii::$app->request->isPjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return Yii::createObject('yii\rest\Serializer', [['collectionEnvelope' => 'items']])->serialize($dataProvider);
        } else {
            return $this->render($this->index_view, [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays a single model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render($this->view_view, [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /** @var \yii\db\ActiveRecord $model */
        $model = new $this->model();
        if ($this->loadAttributes($model, Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index',]);
        } else {
            return $this->render($this->create_view, [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($this->loadAttributes($model, Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index',]);
        } else {
            return $this->render($this->update_view, [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    // custom methods

    /**
     * Finds the Album model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param mixed $condition please refer to [[findOne()]] for the explanation of this parameter
     * @return \yii\db\ActiveRecord the loaded model
     * @throws NotFoundHttpException|ForbiddenHttpException if the model cannot be found
     */
    protected function findModel($condition)
    {
        /** @var \yii\db\ActiveRecord $model */
        $model = $this->model;
        if ($model !== null && ($model = $model::findOne($condition)) !== null) {
            if (Yii::$app->user->can('location', ['model' => $model]) || Yii::$app->user->can('admin')) {
                return $model;
            } else {
                throw new ForbiddenHttpException();
            }
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }

    /**
     * @return array
     */
    protected function getActionTitleList()
    {
        return [];
    }

    /**
     * @param \yii\db\ActiveRecord $model
     * @param array $parameters
     * @return bool
     */
    protected function loadAttributes($model, $parameters){
        if($model->load($parameters)){
            return true;
        }
        return false;
    }
}
