<?php

use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

/**
 * @var $this yii\web\View
 * @var $model common\models\Category
 * @var $dataProvider ActiveDataProvider
 */

$this->title = $model ? $model->name : Yii::t('common/model_labels', 'Products');
$this->params['breadcrumbs'][] = $this->title;

?>
<!--content-->
<div class="products">
    <div class="container">
        <h1><?= $this->title; ?></h1>

        <div class="col-md-12">
            <?= $model->description; ?>
        </div>
        <div class="col-md-9">
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_product',
                'itemOptions' => [
                    'class' => 'col-md-4 product',
                ],
                'options' => ['class' => ''],
                'summary' => false,
            ]); ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!--//content-->