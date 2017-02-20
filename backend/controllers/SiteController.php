<?php
namespace backend\controllers;

use backend\components\BackendController;
use common\components\keyStorage\FormModel;
use Yii;
use common\models\Album;
use common\models\Product;
use zxbodya\yii2\galleryManager\GalleryManagerAction;

/**
 * Site controller
 */
class SiteController extends BackendController
{
	
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'galleryApi' => [
                'class' => GalleryManagerAction::className(),
                // mappings between type names and model classes (should be the same as in behaviour)
                'types' => [
                    Product::className() => Product::className(),
                    Album::className() => Album::className(),
                ]
            ],
        ];
    }
    
     /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $output = parent::behaviors();

        $output['verbs']['actions']['logout'] = ['post'];
        array_unshift(
            $output['access']['rules'],
            [
                'actions' => ['login',],
                'allow' => true,
            ],
            [
                'actions' => ['error', 'logout', 'index', 'galleryApi', 'profile', 'filesystem',],
                'allow' => true,
                'roles' => ['@'],
            ]
        );
        return $output;
    }


    public function beforeAction($action)
    {
        $this->layout = Yii::$app->user->isGuest || !Yii::$app->user->can('loginToBackend') ? 'base' : 'common';
        return parent::beforeAction($action);
    }


    public function actionFilesystem()
    {
        $this->view->title = Yii::t('app', 'Filesystem');
        $this->view->registerJs(<<<JS
    function elfinder_resize(){
        $('.elfinder-wrapper').height($('.content-wrapper').height() - $('.content-header').height()  - $('.main-footer').height()- 70);
    }
    $('.elfinder-wrapper').load(elfinder_resize);
    $(window).resize(elfinder_resize);
JS
);
        return $this->renderContent(\mihaildev\elfinder\ElFinder::widget([
            'controller' => 'elfinder',
            'callbackFunction' => new \yii\web\JsExpression('function(file, id){}'), // id - id виджета
            'containerOptions' => [],
            'frameOptions' => ['class' => 'elfinder-wrapper',],
        ]));
    }

    public function actionSettings()
    {
        $model = new FormModel([
            'keys' => [
                'frontend.maintenance' => [
                    'label' => Yii::t('backend', 'Frontend maintenance mode'),
                    'type' => FormModel::TYPE_DROPDOWN,
                    'items' => [
                        'disabled' => Yii::t('backend', 'Disabled'),
                        'enabled' => Yii::t('backend', 'Enabled')
                    ]
                ],
                'backend.theme-skin' => [
                    'label' => Yii::t('backend', 'Backend theme'),
                    'type' => FormModel::TYPE_DROPDOWN,
                    'items' => [
                        'skin-black' => 'skin-black',
                        'skin-blue' => 'skin-blue',
                        'skin-green' => 'skin-green',
                        'skin-purple' => 'skin-purple',
                        'skin-red' => 'skin-red',
                        'skin-yellow' => 'skin-yellow'
                    ]
                ],
                'backend.layout-fixed' => [
                    'label' => Yii::t('backend', 'Fixed backend layout'),
                    'type' => FormModel::TYPE_CHECKBOX
                ],
                'backend.layout-boxed' => [
                    'label' => Yii::t('backend', 'Boxed backend layout'),
                    'type' => FormModel::TYPE_CHECKBOX
                ],
                'backend.layout-collapsed-sidebar' => [
                    'label' => Yii::t('backend', 'Backend sidebar collapsed'),
                    'type' => FormModel::TYPE_CHECKBOX
                ]
            ]
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('alert', [
                'body' => Yii::t('backend', 'Settings was successfully saved'),
                'options' => ['class' => 'alert alert-success']
            ]);
            return $this->refresh();
        }

        return $this->render('settings', ['model' => $model]);
    }
}
