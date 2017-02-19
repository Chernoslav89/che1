<?php
use kartik\grid\GridView;
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'id',
    ],
    'fullname',
    'tel',
    'email',
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'created_at',
        'format' => 'datetime',
        'width' => '14%',
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => [
            'pluginOptions' => [
                'format' => 'MMMM D, YYYY',
                'opens' => 'left',
            ]
        ]
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
    ],
];