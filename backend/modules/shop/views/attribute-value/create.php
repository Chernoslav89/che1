<?php

use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model common\models\AttributeValue
 * */

$this->title = Yii::t('app', 'Create Attribute Value');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Attribute Values'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attribute-value-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>