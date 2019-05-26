<?php
namespace common\modules\chat\widgets;

use common\modules\chat\widgets;
use Yii;
use yii\web\View;


class Chat extends \yii\bootstrap\Widget
{
    public $port = 8080;
    public function init()
    {
        ChatAsset::register($this->view);
//        $this->view->registerJs('const wsPort = '. $this->port);
        $this->view->registerJsVar('wsPort', $this->port);
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
//        $this->view->registerJsFile('/js/chat.js');
        return $this->render('chat');
    }
}
