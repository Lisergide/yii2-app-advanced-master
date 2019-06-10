<?php

namespace frontend\controllers;

use common\models\Project;
use common\models\ProjectUser;
use common\models\query\TaskQuery;
use common\models\User;
use Yii;
use common\models\Task;
use common\models\search\TaskSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller {
  /**
   * {@inheritdoc}
   */
  public function behaviors() {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'rules' => [
          [
//                        'actions' => ['logout', 'index'],
            'allow' => true,
            'roles' => ['user'],
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
   * Lists all Task models.
   * @return mixed
   */
  public function actionIndex() {
    $searchModel = new TaskSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    $projects = Project::find()->byUser(Yii::$app->user->id)->select('title')->indexBy('id')->column();

    $activeUsers = User::find()->onlyActive()->select('username')->indexBy('id')->column();

    /* @var $query TaskQuery */
    $query = $dataProvider->query;
    $query->byUser(Yii::$app->user->id);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
      'projects' => $projects,
      'activeUsers' => $activeUsers
    ]);
  }

  /**
   * Displays a single Task model.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionView($id) {
    return $this->render('view', [
      'model' => $this->findModel($id),
    ]);
  }

  /**
   * Creates a new Task model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate() {
    $model = new Task();

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
    }

    return $this->render('create', [
      'model' => $model,
    ]);
  }

  /**
   * Updates an existing Task model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($id) {
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
    }

    return $this->render('update', [
      'model' => $model,
    ]);
  }

  /**
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionTake($id) {
    $model = $this->findModel($id);
    $user = Yii::$app->user->identity;
    $userRoles = $model->getTaskUserRoles();
    if (Yii::$app->taskService->takeTask($model, $user)) {
      Yii::$app->session->setFlash('success', 'Вы взяли задачу');
      foreach ($userRoles as $userId => $role) {
        if ($role === ProjectUser::ROLE_MANAGER) {
          Yii::$app->taskService->assignTask($model, User::findOne($userId));
        }
      }
      return $this->redirect(['view', 'id' => $model->id]);
    }

    return $this->render('view', [
      'model' => $model,
    ]);
  }

  /**
   * @param $id
   * @return string|\yii\web\Response
   * @throws NotFoundHttpException
   */
  public function actionComplete($id) {
    $model = $this->findModel($id);
    $userRoles = $model->getTaskUserRoles();

    if (Yii::$app->taskService->completeTask($model)) {
      Yii::$app->session->setFlash('success', 'Вы завершили задачу');
      foreach ($userRoles as $userId => $role) {
        if ($role === ProjectUser::ROLE_MANAGER || $role === ProjectUser::ROLE_TESTER) {
          Yii::$app->taskService->completeTaskEvent($model, User::findOne($userId));
        }
      }
      return $this->redirect(['view', 'id' => $model->id]);
    }

    return $this->render('view', [
      'model' => $model,
    ]);
  }


  /**
   * Deletes an existing Task model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id) {
    $this->findModel($id)->delete();

    return $this->redirect(['index']);
  }

  /**
   * Finds the Task model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Task the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id) {
    if (($model = Task::findOne($id)) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
  }
}
