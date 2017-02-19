<?php
use common\models\User;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;

/**
 * @var $this yii\web\View
 * */
$model = $this->context->getCategories($parent_id);

$this->registerJs(<<<JS
var menu_ul = $('.menu-drop > li > ul'),
    menu_a = $('.menu-drop > li > a');
    menu_ul.hide();
    menu_a.click(function (e) {
    if($(this).next('.cute').length > 0){
        e.preventDefault();
        if (!$(this).hasClass('active')) {
            menu_a.removeClass('active');
            menu_ul.filter(':visible').slideUp('normal');
            $(this).addClass('active').next().stop(true, true).slideDown('normal');
        } else {
            $(this).removeClass('active');
            $(this).next().stop(true, true).slideUp('normal');
        }
    }
});
JS
);

?>
<!--categories-->
<div class=" rsidebar span_1_of_left">
    <h3 class="cate"><?= Yii::t('common/model_labels', 'Categories') ?></h3>
    <ul class="menu-drop">
        <?php if (empty($model)): ?>
            <?= Yii::t('app', 'No subcategories') ?>
        <?php else: ?>
            <?php foreach ($model as $category): ?>
                <li class="item1">
                    <a href="<?= Url::toRoute(['/shop/default/index', 'id' => $category->id, 'city_alias' => \common\models\City::getCurrentCityAlias()]); ?>"
                       class="<?= $category->subCategories ? 'has_children' : ''; ?>"
                        >
                        <?= $category->name; ?>
                    </a>
                    <?php if ($category->subCategories): ?>
                        <ul class="cute">
                            <?php foreach ($category->subCategories as $subCategory): ?>
                                <li class="subitem1">
                                    <a href="<?= Url::toRoute(['/shop/default/index', 'id' => $subCategory->id, 'city_alias' => \common\models\City::getCurrentCityAlias()]); ?>">
                                        <?= $subCategory->name; ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>
<!--//menu-->
