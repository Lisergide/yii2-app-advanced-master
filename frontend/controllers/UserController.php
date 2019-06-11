<?php

namespace frontend\controllers;

use common\models\ProjectUser;
use Yii;
use common\models\User;
use frontend\models\search\UserSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {
  /**
   * {@inheritdoc}
   */
  public function behaviors() {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'denyCallback' => function ($rule, $action) {
          throw new ForbiddenHttpException('У Вас нет доступа');
        },
        'rules' => [
          [
            'allow' => true,
            'roles' => [ProjectUser::ROLE_TESTER],
          ],
        ],
      ],
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'delete' => ['POST'],
        ],
      ],
    ];
  }

  /**
   * Displays a single User model.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionView() {
    $model = $this->findModel(Yii::$app->user->identity->id);

    $query = $model->getProjectUsers();
    $dataProvider = new ActiveDataProvider([
      'query' => $query,
    ]);

    return $this->render('view', [
      'model' => $model,
      'dataProvider' => $dataProvider
    ]);
  }

  /**
   * @return mixed
   * @throws NotFoundHttpException
   */
  public function actionProfile() {
    $model = $this->findModel(Yii::$app->user->identity->id);
    $model->setScenario(User::SCENARIO_UPDATE);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
    }

    return $this->render('profile', [
      'model' => $model,
    ]);

  }

  /**
   * Finds the User model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return User the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id) {
    if (($model = User::findOne($id)) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
  }
}
