<?php


namespace common\services;


use common\models\Project;
use common\models\User;
use Yii;
use yii\base\Component;

class NotificationService extends Component
{

    protected $emailService;

    /**
     * NotificationService constructor.
     * @param EmailServiceInterface $emailService
     * @param array $config
     */
    public function __construct(EmailServiceInterface $emailService, array $config = [])
    {
        parent::__construct($config);
        $this->emailService = $emailService;
    }

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
        $this->emailService->send($to, $subject, $viewHTML, $viewText, $data);
    }

}