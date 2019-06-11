<?php

namespace frontend\modules\api\controllers;

use frontend\modules\api\models\Project;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;


/**
 * Default controller for the `api` module
 */
class ProjectController extends ActiveController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
        ];
        return $behaviors;
    }

    public $modelClass = Project::class;
}
