<?php

use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $searchModel yii\db\ActiveRecord
 * @var $dataProvider yii\data\ActiveDataProvider
 * */

$this->title = ArrayHelper::getValue($this->context->getActionTitleList(), $this->context->action->id, Yii::t('app', 'Items'));
$this->params['breadcrumbs'][] = $this->title;

$dataProvider->sort->defaultOrder = [
    'created_at' => SORT_DESC,
];
?>
<div class="album-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => require($this->context->viewPath . '/_columns.php'),
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'pjax' => true, // pjax is set to always true for this demo
        'beforeHeader' => [],
        // set your toolbar
        'toolbar' => [
            ['content' =>
                Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['data-pjax' => 0, 'type' => 'button', 'title' => Yii::t('app', 'Add item'), 'class' => 'btn btn-success']) . ' ' .
                Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['class' => 'btn btn-default', 'title' => Yii::t('app', 'Reset Grid')])
            ],
            '{export}',
            '{toggleData}',
        ],
        // set export properties
        'export' => [
            'fontAwesome' => true
        ],
        // parameters from the demo form
        'panel' => [
            'type' => Yii::$app->params['GridView-type'][Yii::$app->keyStorage->get('backend.theme-skin')],
        ],
        'persistResize' => false,
    ]); ?>
</div>