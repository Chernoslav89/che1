<?php

use yii\helpers\Html;


/**
 * @var $this yii\web\View
 * @var $model common\models\Product
 * */

$this->title = Yii::t('app', 'Create {modelClass}: ', [
    'modelClass' => Yii::t('common/model_labels', 'Products'),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('common/model_labels', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create"><?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>