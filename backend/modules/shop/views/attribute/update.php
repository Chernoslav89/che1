<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Attribute */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => Yii::t('common/model_labels', 'Attributes'),
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common/model_labels', 'Attributes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="attribute-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
