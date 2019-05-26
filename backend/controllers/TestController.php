<?php
// Создать страницу «Hello, world» в бэкэнде приложении (создаем контроллер-экшен).
namespace backend\controllers;

use common\models\User;
use yii\web\Controller;

class TestController extends Controller
{

    public function actionIndex()
    {

        $model = User::findOne(1);

        print_r($model->toArray()); exit();

        return "Hello, World!";
    }
}
