<?php
// Создать страницу «Hello, world» в бэкэнде приложении (создаем контроллер-экшен).
namespace backend\controllers;

use yii\web\Controller;

class TestController extends Controller
{

    public function actionIndex()
    {
        return "Hello, World!";
    }
}
