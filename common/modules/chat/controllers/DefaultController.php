<?php

namespace common\modules\chat\controllers;

use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Yii;
use yii\console\Controller;
use Ratchet\Server\IoServer;
use common\modules\chat\components\Chat;

/**
 * Default controller for the `chat` module
 */
class DefaultController extends Controller
{

    public function actionIndex()
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                )
            ),
            Yii::$app->params['chat.port']
        );
        echo 'Server start'.PHP_EOL;

        // loop для поддержания коннекта к БД
        $server->loop->addPeriodicTimer(2, function (){
           echo date('H:i:s').PHP_EOL;
        });

        $server->run();
        echo 'Server end';
    }
}
