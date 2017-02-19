<?php

use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model common\models\AttributeValue
 * */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Attribute Value',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Attribute Values'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="attribute-value-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>