<?php


namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

//        // добавляем разрешение "createPost"
//        $createPost = $auth->createPermission('createPost');
//        $createPost->description = 'Create a post';
//        $auth->add($createPost);
//
//        // добавляем разрешение "updatePost"
//        $updatePost = $auth->createPermission('updatePost');
//        $updatePost->description = 'Update post';
//        $auth->add($updatePost);

        // добавляем роль "user" и даём роли разрешение "createPost"
        $user = $auth->createRole('user');
        $auth->add($user);
//        $auth->addChild($author, $createPost);

        // добавляем роль "admin" и даём роли разрешение "updatePost"
        // а также все разрешения роли "author"
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $user);
//        $auth->addChild($admin, $updatePost);

        // Назначение ролей пользователям. 1 и 2 это IDs возвращаемые IdentityInterface::getId()
        // обычно реализуемый в модели User.
        $auth->assign($admin, 1);
        $auth->assign($user, 2);
        $auth->assign($user, 3);
        $auth->assign($user, 4);
        $auth->assign($user, 5);
        $auth->assign($user, 6);
        $auth->assign($user, 7);
        $auth->assign($user, 8);
        $auth->assign($user, 9);
        $auth->assign($user, 10);
        $auth->assign($user, 11);
        $auth->assign($user, 12);
        $auth->assign($user, 13);
    }
}