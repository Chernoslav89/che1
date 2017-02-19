<?php

use common\models\Order;
use common\models\Product;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * @var $this yii\web\View
 * @var $model common\models\Order
 * @var yz\shoppingcart\ShoppingCart $cart
 */

$cart = Yii::$app->cart;
$this->title = Yii::t('app', 'Checkout');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="container">
    <?php Pjax::begin([
        'id' => 'cart-big',
        'options' => [
            'class' => 'check-out',
            'data' => [
                'pjax-options' => [
                    'url' => Url::toRoute(['/shop/default/cart']),
                    'type' => 'POST',
                    'push' => false,
                    'scrollTo' => false,
                ],
            ],
        ],
        'clientOptions' => [
            'type' => 'POST',
            'url' => Url::toRoute(['/shop/default/cart'])
        ]
    ]); ?>
    <h1><?= $this->title ?></h1>
    <?php if ($cart->getIsEmpty()): ?>
        <div class="">
            <?= Yii::t('app', 'Cart is empty') ?>
        </div>
    <?php else: ?>
        <table>
            <tr>
                <th><?= Yii::t('app', 'Item') ?></th>
                <th><?= Yii::t('app', 'Quantity') ?></th>
                <th><?= Yii::t('app', 'Prices') ?></th>
                <th><?= Yii::t('app', 'Subtotal') ?></th>
            </tr>
            <?php foreach ($cart->getPositions() as $position):
                /** @var $position Product */ ?>
                <tr>
                    <td class="ring-in">
                        <?= Html::a(
                            Html::img($position->getImage(), ['class' => 'img-responsive']),
                            ['/shop/default/product', 'id' => $position->id, 'city_alias' => \common\models\City::getCurrentCityAlias()],
                            ['class' => 'at-in', 'data' => ['pjax' => '0']]
                        ) ?>
                        <div class="sed">
                            <h5><?= $position->name ?></h5>

                            <p><?= \yii\helpers\StringHelper::truncateWords($position->description, 10, '...', true) ?></p>
                        </div>
                        <div class="clearfix"></div>
                    </td>
                    <td class="check">
                        <?= Html::input('text', null, $position->quantity, [
                                'data' => ['position' => $position->id],
                                'class' => "cart-position-quantity"
                            ]
                        ) ?>
                    </td>
                    <td><?= Yii::$app->formatter->asCurrency($position->price, 'UAH') ?></td>
                    <td><?= Yii::$app->formatter->asCurrency($position->cost, 'UAH') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <th></th>
                <th><?= $cart->count ?></th>
                <th><?= Yii::t('app', 'Total') ?></th>
                <th><?= Yii::$app->formatter->asCurrency($cart->cost, 'UAH') ?></th>
            </tr>
        </table>
        <?php $form = ActiveForm::begin([
            'options' => ['data-pjax' => 1,],
        ]); ?>
        <?= Html::hiddenInput('action', 'order') ?>
        <?= $form->field($model, 'fullname')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'delivery_address')->textarea(['rows' => 6]) ?>
        <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'to-buy']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>
    <div class="clearfix"></div>
    <?php Pjax::end(); ?>
</div>