<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/**
 * @var $this yii\web\View
 * @var $model common\models\Product the Product model
 * @var $key mixed the key value associated with the data item
 * @var $index integer the zero-based index of the data item in the items array returned by [[dataProvider]].
 * @var $widget yii\widgets\ListView this widget instance
 */
?>
<div class="col-md1 simpleCart_shelfItem">
    <?= Html::a(
        Html::img(
            $model->getImage(),
            ['class' => 'img-responsive']
        ),
        ['/shop/default/product', 'id' => $model->id, 'city_alias' => \common\models\City::getCurrentCityAlias()]
    ) ?>
    <h3>
        <?= Html::a($model->name, ['/shop/default/product', 'id' => $model->id]) ?>
    </h3>

    <div class="price">
        <h5 class="item_price"><?= $model->getPrice() ?></h5>
        <?= Html::a(Yii::t('app', 'Add To Cart'), 'javascript:;', ['class' => 'item_add add_product_to_cart', 'data' => ['product-id' => $model->id]]) ?>
        <div class="clearfix"></div>
    </div>
</div>