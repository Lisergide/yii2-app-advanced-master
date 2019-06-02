<?php

namespace frontend\modules\api\controllers;

use yii\rest\ActiveController;
use common\models\User;


/**
 * Default controller for the `api` module
 */
class UserController extends ActiveController
{
    public $modelClass = User::class;
}
