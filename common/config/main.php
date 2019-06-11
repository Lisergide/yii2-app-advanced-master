<?php
return [
  'aliases' => [
    '@bower' => '@vendor/bower-asset',
    '@npm' => '@vendor/npm-asset',
  ],
  'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
  'components' => [
    'i18n' => [
      'translations' => [
        'yii2mod.comments' => [
          'class' => 'yii\i18n\PhpMessageSource',
          'basePath' => '@yii2mod/comments/messages',
        ],
      ],
    ],
    'authManager' => [
      'class' => 'yii\rbac\DbManager',
    ],
    'cache' => [
      'class' => 'yii\caching\FileCache',
    ],
    'emailService' => [
      'class' => \common\services\EmailService::class,
    ],
    'notificationService' => [
      'class' => \common\services\NotificationService::class,
    ],
    'taskService' => [
      'class' => \common\services\TaskService::class,
      'on ' . \common\services\TaskService::EVENT_ASSIGN_TASK =>
        function (\common\services\AssignTaskEvent $e) {
          Yii::$app->notificationService->sendAboutTakingTask($e->user, $e->task);
        },
      'on ' . \common\services\TaskService::EVENT_COMPLETE_TASK =>
        function (\common\services\AssignTaskEvent $e) {
          Yii::$app->notificationService->sendAboutCompleteTask($e->user, $e->task);
        }
    ],
    'projectService' => [
      'class' => \common\services\ProjectService::class,
      'on ' . \common\services\ProjectService::EVENT_ASSIGN_ROLE =>
        function (\common\services\AssignRoleEvent $e) {
//                    var_dump($e->dump()); exit;
          Yii::$app->notificationService->sendAboutNewProjectRole($e->user, $e->project, $e->role);
        },
    ],
  ],
  'modules' => [
    'chat' => [
      'class' => 'common\modules\chat\Module',
    ],
    'comment' => [
      'class' => 'yii2mod\comments\Module',
    ],
  ],
];
