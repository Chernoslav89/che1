<?php

use common\models\Order;
use common\models\OrderItem;
use common\models\Product;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Order */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
        'modelClass' => Yii::t('common/model_labels', 'Orders'),
    ]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common/model_labels', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="order-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <div class="product-form">
        <?php
            echo GridView::widget([
                'dataProvider' => Yii::createObject(ActiveDataProvider::className(), [['query' => $model->getOrderItems()]]),
                //'filterModel' => $searchModel,
                'columns' => [
                    [
                        'class' => 'kartik\grid\SerialColumn',
                        'width' => '30px',
                    ],
                    [
                        'class'=>'\kartik\grid\DataColumn',
                        'attribute'=>'product_id',
                        'width'=>'180px',
                        'value'=>function ($model, $key, $index, $widget) {
                            /** @var OrderItem $model */
                            return Html::a($model->product->name, Url::to(['product/view', 'id' => $model->product_id]), []);
                        },
                        'format'=>'raw'
                    ],
                    [
                        'attribute'=>'quantity',
                        'format'=>['decimal', 2],
                        'pageSummary'=>true
                    ],
                    [
                        'attribute'=>'price',
                        'format'=>['decimal', 2],
                        'pageSummary'=>true
                    ],/*/
                    [
                        'attribute'=>'sale',
                        'format'=>['decimal', 2],
                        'pageSummary'=>true
                    ],/**/
                    [
                        'class'=>'kartik\grid\FormulaColumn',
                        'header'=> Yii::t('app', 'Cost'),
                        'value'=>function ($model, $key, $index, $widget) {
                            $p = compact('model', 'key', 'index');
                            return $widget->col(2, $p) * $widget->col(3, $p)/*/ - $widget->col(4, $p)/**/;
                        },
                        'format'=>['decimal', 2],
                        'pageSummary'=>true,
                    ],
                ],
                'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                'filterRowOptions' => ['class' => 'kartik-sheet-style'],
                'pjax' => true, // pjax is set to always true for this demo
                'pjaxSettings' => [
                    'options' => [
                        'id' => 'product-attribute_value-pjax'
                    ],
                ],
                'beforeHeader' => [],
                // set your toolbar
                'toolbar' => [
                    ['content' =>
                        Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['', 'id' => $model->id,], ['class' => 'btn btn-default', 'title' => Yii::t('app', 'Reset Grid')])
                    ],
                    //'{export}',
                    '{toggleData}',
                ],
                // set export properties
                'export' => [
                    'fontAwesome' => true
                ],
                // parameters from the demo form
                'panel' => [
                    'type' => Yii::$app->params['GridView-type'][Yii::$app->keyStorage->get('backend.theme-skin')],
                    'heading' => Yii::t('common/model_labels', 'Products')
                ],
                'persistResize' => false,
                'showPageSummary'=> true,
            ]); ?>
    </div>
</div>
