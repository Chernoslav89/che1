<?php

namespace frontend\modules\shop\controllers;


use common\models\Category;
use common\models\Order;
use common\models\OrderItem;
use common\models\Product;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\ServerErrorHttpException;

class DefaultController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        $category_id = Yii::$app->request->getQueryParam('id', 0);
        $city_alias = Yii::$app->request->getQueryParam('city_alias', '');
        $model = \common\models\Category::find()
            ->joinWith('city')
            ->filterWhere(['{{%shop_category}}.id' => $category_id, '{{%city}}.alias' => $city_alias])
            ->one();

        $dataProvider = new ActiveDataProvider([
            'query' => Product::getFilter(ArrayHelper::merge(Yii::$app->request->getQueryParam('filter', []), ['id-categories' => $category_id])),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * @return string
     */
    public function actionProduct()
    {
        $product_id = Yii::$app->request->getQueryParam('id', 0);
        $model = $this->findModel(Product::className(), $product_id);
        return $this->render('product', ['model' => $model,]);
    }

    /**
     * @return string
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCart()
    {
        /**
         * @var \yz\shoppingcart\ShoppingCart $cart
         * @var Product $position
         * */
        $cart = \Yii::$app->cart;
        $request = Yii::$app->request;
        $model = new Order([
            'status' => 1,
            'scenario' => Order::SCENARIO_NEW
        ]);
        if ($request->isPjax) {
            switch($request->getBodyParam('action')){
                case 'add':
                    $params = $request->getBodyParam('params');
                    $position = Product::findOne($params['product_id']);
                    $position->detachBehaviors();
                    $cart->put($position, $params['quantity'] ?: 1);
                    break;
                case 'update':
                    $params = $request->getBodyParam('params');
                    if (isset($params['quantity'],$params['position']) && ($position = Product::findOne($params['position']))) {
                        $cart->update($position, $params['quantity']);
                    }
                    break;
                case 'clear':
                    $cart->removeAll();
                    break;
                case 'order':
                    if ($model->load(Yii::$app->getRequest()->getBodyParams()) && $model->save()) {
                        foreach ($cart->getPositions() as $position) {
                            $t[] = $item = new OrderItem([
                                'name' => $position->name,
                                'price' => $position->price,
                                'quantity' => $position->quantity,
                                'product_id' => $position->id,
                            ]);
                            $item->link('order',$model);
                        }
                        $cart->removeAll();
                    } elseif (!$model->hasErrors()) {

                        throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
                    }
                    break;
            }
        }

        /*/
        $product = Product::findOne(rand(1, 9));
        $product->detachBehaviors();
        $cart->put($product, 1);
        if ($cart->getCount() > 7) $cart->removeAll();
        /**/
        return $this->render('cart', ['model' => $model]);
    }

    public function getCategories($parent_id = 0)
    {
        $city_alias = Yii::$app->request->getQueryParam('city_alias', '');
        return \common\models\Category::find()
            ->with('subCategories')
            ->joinWith('city')
            ->filterWhere(['parent_id' => $parent_id ?: 0, '{{%city}}.alias' => $city_alias])
            ->all();
    }

    /**
     * Finds the Album model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param $model_class
     * @param mixed $condition please refer to [[findOne()]] for the explanation of this parameter
     * @return \yii\db\ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($model_class, $condition)
    {
        /** @var \yii\db\ActiveRecord $model */
        if ($model_class !== null && ($model = $model_class::findOne($condition)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
    }
}
