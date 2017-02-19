<?php

/**
 * @var $this yii\web\View
 * @var $model common\models\Product
 */


use common\models\AttributeValue;
use frontend\assets\AppAsset;

$this->title = Yii::t('common/model_labels', 'Products');
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile('css/flexslider.css', ['depends' => [AppAsset::className()]]);
$this->registerJsFile('js/jquery.flexslider.js', ['depends' => [AppAsset::className()]]);
$this->registerJs(<<<JS
$('.flexslider').flexslider({
    animation: "slide",
    controlNav: "thumbnails"
});
JS
);

$this->registerCssFile('css/popuo-box.css', ['depends' => [AppAsset::className()]]);
$this->registerJsFile('js/jquery.magnific-popup.js', ['depends' => [AppAsset::className()]]);
$this->registerJs(<<<JS
$('.popup-with-zoom-anim').magnificPopup({
    type: 'inline',
    fixedContentPos: false,
    fixedBgPos: true,
    overflowY: 'auto',
    closeBtnInside: true,
    preloader: false,
    midClick: true,
    removalDelay: 300,
    mainClass: 'my-mfp-zoom-in'
});
JS
);
?>
<div class="single">
    <div class="container">
        <div class="col-md-9">
            <div class="col-md-5 grid">
                <div class="flexslider">
                    <ul class="slides">
                        <?php if (is_array($model->images) && !empty($model->images)): ?>
                            <?php foreach ($model->images as $image): ?>
                                <li data-thumb="<?= $image->getPreview() ?>">
                                    <div class="thumb-image">
                                        <img src="<?= $image->getHref() ?>"
                                             data-imagezoom="true"
                                             alt="<?= $image->name ?>"
                                             class="img-responsive">
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li data-thumb="<?= $model->getImage() ?>">
                                <div class="thumb-image">
                                    <img src="<?= $model->getImage() ?>"
                                         data-imagezoom="true"
                                         class="img-responsive">
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-7 single-top-in">
                <div class="single-para simpleCart_shelfItem">
                    <h1><?= $model->name; ?></h1>

                    <p>
                        <?= $model->description; ?>
                    </p>

                    <div>
                        <?php if (is_array($model->attributeValues) && !empty($model->attributeValues)): ?>
                            <?php foreach ($model->attributeValues as $attributeValue):
                                /** @var $attributeValue AttributeValue */ ?>
                                <?= $attributeValue->productAttribute->name ?> : <?= $attributeValue->value ?><br>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <label
                        class="add-to item_price"><?= Yii::$app->formatter->asCurrency($model->price, 'UAH'); ?></label>
                    <a href="javascript:;" class="cart item_add add_product_to_cart"
                       data-product-id="<?= $model->id ?>"><?= Yii::t('app', 'Add To Cart') ?></a>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="col-md-3 product-bottom">
            <?= $this->render('_right_bar') ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>