<?php
namespace app\modules\admin\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;
use Yii;
class AppController extends Controller
{
    public function init()
    {
        parent::init();

        $this->layout = 'main';

    }
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login'], // Доступ к действию 'login' для всех
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'], // '@' означает авторизованный пользователь
                    ]
                ],
                'denyCallback' => function ($rule, $action) {
                    // Перенаправление на страницу входа
                    Yii::$app->response->redirect(['site/login']);
                }
            ],

        ];
    }
}