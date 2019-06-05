<?php

namespace common\services;

use yii\base\Component;

class EmailService extends Component
{
    /**
     * @param string $to
     * @param string $subject
     * @param [] $viewHTML
     * @param [] $viewText
     * @param [] $data
     */
    public function send($to, $subject, $viewHTML, $viewText, $data)
    {
        \Yii::$app
            ->mailer
            ->compose(['html' => $viewHTML, 'text' => $viewText], $data)
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . 'robot'])
            ->setTo($to)
            ->setSubject($subject)
            ->send();
    }

}