<?php


namespace console\controllers;

use common\models\ProjectUser;
use Yii;
use yii\console\Controller;

class RbacController extends Controller {
  public function actionInit() {
    $auth = Yii::$app->authManager;

    // добавляем роль "tester".
    $tester = $auth->createRole(ProjectUser::ROLE_TESTER);
    $auth->add($tester);

    // добавляем роль "developer".
    // а также все разрешения роли "tester"
    $developer = $auth->createRole(ProjectUser::ROLE_DEVELOPER);
    $auth->add($developer);
    $auth->addChild($developer, $tester);

    // добавляем роль "manager".
    // а также все разрешения роли "developer"
    $manager = $auth->createRole(ProjectUser::ROLE_MANAGER);
    $auth->add($manager);
    $auth->addChild($manager, $developer, $tester);

    // добавляем роль "admin".
    $admin = $auth->createRole(ProjectUser::ROLE_ADMIN);
    $auth->add($admin);
    $auth->addChild($admin, $manager, $developer, $tester);

    // Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId()
    // обычно реализуемый в модели User.
    $auth->assign($admin, 1);
    $auth->assign($manager, 2);
    $auth->assign($developer, 3);
    $auth->assign($tester, 4);
  }
}