<?php


namespace common\services;


use common\models\Project;
use common\models\User;
use Yii;
use yii\base\Component;

class NotificationService extends Component
{

    /**
     * @param User $user
     * @param Project $project
     * @param string $role
     */
    public function sendAboutNewProjectRole(User $user, Project $project, $role)
    {
        $to = $user->email;
        $subject = 'Assign role';
        $viewHTML = 'assignRole-html';
        $viewText = 'assignRole-text';
        $data = ['user' => $user, 'project' => $project, 'role' => $role];
        Yii::$app->emailService->send($to, $subject, $viewHTML, $viewText, $data);
    }

}