<?php

use common\models\City;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model common\models\Order
 * @var $form yii\widgets\ActiveForm
 * */
?>
<div class="order-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'user_id')->textInput() ?>
    <?= $form->field($model, 'status')->textInput() ?>
    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'delivery_address')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?php if (!$model->isNewRecord): ?>
        <div class="form-group field-album-created_at">
            <label class="control-label" for="album-name"><?= $model->getAttributeLabel('created_at'); ?></label>
            <br/>
            <?= Yii::$app->formatter->asDate($model->created_at) ?>
            <div class="help-block"></div>
        </div>
        <div class="form-group field-album-created_at">
            <label class="control-label" for="album-name"><?= $model->getAttributeLabel('updated_at'); ?></label>
            <br/>
            <?= Yii::$app->formatter->asDate($model->updated_at) ?>
            <div class="help-block"></div>
        </div>
    <?php endif; ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
