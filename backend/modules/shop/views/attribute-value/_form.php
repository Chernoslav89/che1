<?php

use kartik\widgets\Select2;;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model common\models\AttributeValue
 * @var $form yii\widgets\ActiveForm
 * */

?>
<div class="attribute-value-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'attribute_id')->widget(
        Select2::classname(),
        [
            'initValueText' => empty($model->productAttribute) ? '' : $model->productAttribute->name,
            //'options' => ['placeholder' => ''],
            'pluginOptions' => [
                //'allowClear' => true,
                'ajax' => [
                    'url' => Url::toRoute(['/shop/attribute/index']),
                    'dataType' => 'json',
                    'data' => new JsExpression(<<< JS
function (params) {
   return {
       AttributeSearch:{
           name: params.term
       },
       page: params.page
   };
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
            ],
        ]
    ); ?>
    <?= $form->field($model, 'value')->textarea(['rows' => 4]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>