<?php
// Создать страницу «Hello, world» в фротэнде приложении (создаем контроллер-экшен).
namespace frontend\controllers;

use yii\web\Controller;

class TestController extends Controller
{

    public function actionIndex()
    {
        return "Hello, World!";
    }
}
