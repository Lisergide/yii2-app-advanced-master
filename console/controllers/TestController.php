<?php
// Создать страницу «Hello, world» в консольном приложении (создаем контроллер-экшен).
namespace console\controllers;

use yii\console\Controller;

class TestController extends Controller
{

    /**
     * Test action
     */
    public function actionIndex()
    {
        echo "Hello, World!".PHP_EOL;
    }
}
