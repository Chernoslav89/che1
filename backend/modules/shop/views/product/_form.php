<?php

use common\models\Attribute;
use common\models\AttributeValue;
use common\models\Category;
use common\models\City;
use common\models\search\AttributeValueSearch;
use kartik\grid\GridView;
use kartik\widgets\Select2;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use zxbodya\yii2\galleryManager\GalleryManager;

/**
 * @var $this yii\web\View
 * @var $model common\models\Product
 * @var $form yii\widgets\ActiveForm
 * */

?>
<div class="product-form">
    <div
        class="panel panel-<?= Yii::$app->params['GridView-type'][Yii::$app->keyStorage->get('backend.theme-skin')] ?>"
        >
        <div class="panel-heading"><?= Yii::t('app', 'Main') ?></div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
            <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'categories')->widget(
                Select2::classname(),
                [
                    'data' => ArrayHelper::map($model->getCategories()->all(), 'id', 'name'),
                    'options' => ['placeholder' => '', 'multiple' => true,],
                    'pluginOptions' => [
                        //'allowClear' => true,
                        'multiple' => true,
                        /**/
                        'ajax' => [
                            'url' => Url::toRoute(['/shop/category/index']),
                            'dataType' => 'json',
                            'data' => new JsExpression(<<<JS
function (params) {
    data = {
       CategorySearch:{
           name: params.term
       },
       page: params.page
   };

   return data;
}
JS
                            ),
                            'processResults' => new JsExpression(<<< JS
function (data, params) {
   return {
       results: data.items,
       pagination: {
           more: data._meta.currentPage < data._meta.pageCount
       }
   };
}
JS
                            ),
                            'cache' => true,
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(data) { return data.name; }'),
                        'templateSelection' => new JsExpression('function (data) { console.log(data); return data.name || data.text; }'),
                        /**/
                    ],
                ]
            ); ?>
            <div class="form-group">
                <?= ($model->isNewRecord) ?
                    Yii::t('app', 'Can not upload images for new record') :
                    GalleryManager::widget(
                        [
                            'model' => $model,
                            'behaviorName' => 'galleryBehavior',
                            'apiRoute' => '/site/galleryApi'
                        ]
                    );
                ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <?php if ($model->isNewRecord): ?>
        <div
            class="panel panel-<?= Yii::$app->params['GridView-type'][Yii::$app->keyStorage->get('backend.theme-skin')] ?>"
            >
            <div class="panel-heading"><?= Yii::t('common/model_labels', 'Attributes') ?></div>
            <div class="panel-body">
                <?= Yii::t('app', 'Can not add attributes for new record') ?>
            </div>
        </div>
    <?php else :
        $dataProvider = (new AttributeValueSearch())->search(Yii::$app->request->queryParams);
        $dataProvider->query->andWhere(['product_id' => $model->id]);
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                [
                    'class' => '\kartik\grid\EditableColumn',
                    'attribute' => 'attribute_id',
                    'value' => function ($model, $key, $index, $widget) {
                        /** @var AttributeValue $model */
                        return isset($model->productAttribute) ? $model->productAttribute->name : null;
                    },
                    'width' => '40%',
                    'editableOptions' => function ($model, $key, $index, $widget) {
                        return [
                            'ajaxSettings' => ['url' => Url::toRoute(['/shop/attribute-value/update', 'id' => $model->id])],
                            'inputType' => \kartik\editable\Editable::INPUT_SELECT2,
                            'options' => [
                                'data' => ArrayHelper::map(Attribute::find()->orderBy('name')->asArray()->all(), 'id', 'name'),
                            ]
                        ];
                    },
                ],
                [
                    'class' => '\kartik\grid\EditableColumn',
                    'attribute' => 'value',
                    'editableOptions' => function ($model, $key, $index, $widget) {
                        return [
                            'ajaxSettings' => ['url' => Url::toRoute(['/shop/attribute-value/update', 'id' => $model->id])],
                        ];
                    },
                ],
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'urlCreator' => function ($action, $model_av, $key, $index) use ($model) {
                        return Url::toRoute(["attribute-value/{$action}", 'product_id' => $model->id, 'id' => $model_av->id,]);
                    },
                    'template' => '{update} {delete}',
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
                    Html::a(
                        '<i class="glyphicon glyphicon-plus"></i>',
                        [
                            '/shop/attribute-value/create',
                            'product_id' => $model->id,
                        ],
                        [
                            'type' => 'button',
                            'title' => Yii::t('app', 'Add item'),
                            'class' => 'btn btn-success',
                        ]
                    ) .
                    ' ' .
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
                'heading' => Yii::t('common/model_labels', 'Attributes')
            ],
            'persistResize' => false,
        ]);
    endif; ?>
</div>