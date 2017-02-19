<?php

use common\models\Category;
use common\models\City;
use kartik\widgets\Select2;
use mihaildev\elfinder\InputFile;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model common\models\Category
 * @var $form yii\widgets\ActiveForm
 * */
?>
<div class="category-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'cover')->widget(InputFile::className(), [
        'controller' => 'elfinder',
        'filter' => 'image',
        'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options' => [
            'class' => ['form-control', 'input_preview'],
            'data' => ['default-src' => Yii::getAlias('@frontendUrl/img/no_image.png')],
        ],
        'buttonOptions' => ['class' => 'btn btn-default'],
        'multiple' => false
    ]); ?>
    <?= $form->field($model, 'parent_id')->widget(
        Select2::classname(),
        [
            'data' => ArrayHelper::map(Category::find()->all(), 'id', 'name'),
            'options' => [
                'placeholder' => '',
                'prompt' => '-',
            ],
            'pluginOptions' => [
                'allowClear' => true,
                /*/
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
                /**/
            ],
        ]
    ); ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>