<?php

use common\models\ProjectUser;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Task;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $projects [] */
/* @var $activeUsers [] */
/* @var $model common\models\Task */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

  <?php Pjax::begin(); ?>
  <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

  <?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
      [
        'attribute' => 'project_id',
        'label' => 'Project',
        'filter' => $projects,
        'value' => function (Task $model) {
          return Html::a($model->project->title, ['project/view', 'id' => $model->project->id]);
        },
        'format' => 'html',
      ],
      'title',
      'description:ntext',
      [
        'attribute' => Task::RELATION_EXECUTOR,
        'label' => 'Executor',
        'filter' => $activeUsers,
        'value' => function (Task $model) {
          return Html::a($model->executor->username, ['user/view', 'id' => $model->executor_id]);
        },
        'format' => 'html',
      ],
      'started_at:datetime',
      'completed_at:datetime',
      [
        'attribute' => Task::RELATION_CREATOR,
        'label' => 'Creator',
        'filter' => $activeUsers,
        'value' => function (Task $model) {
          return Html::a($model->creator->username, ['user/view', 'id' => $model->creator_id]);
        },
        'format' => 'html',
      ],
      'created_at:datetime',
      [
        'attribute' => Task::RELATION_UPDATER,
        'label' => 'Updater',
        'filter' => $activeUsers,
        'value' => function (Task $model) {
          return Html::a($model->updater->username, ['user/view', 'id' => $model->updater_id]);
        },
        'format' => 'html',
      ],
      'updated_at:datetime',
      [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view} {update} {delete} {take} {complete}',
        'buttons' => [
          'take' => function ($url, Task $model, $key) {
            $icon = \yii\bootstrap\Html::icon('plus');
            return Html::a($icon, ['task/take', 'id' => $model->id], ['data' => [
              'confirm' => 'Взять в работу?',
              'method' => 'post',
            ]]);
          },
          'complete' => function ($url, Task $model, $key) {
            $icon = \yii\bootstrap\Html::icon('ok');
            return Html::a($icon, ['task/complete', 'id' => $model->id], ['data' => [
              'confirm' => 'Закончить работу?',
              'method' => 'post',
            ]]);
          }
        ],
        'visibleButtons' => [
          'update' =>
            function (Task $model, $key, $index) {
              return Yii::$app->taskService->canManage($model->project, Yii::$app->user->identity);
            },
          'delete' =>
            function (Task $model, $key, $index) {
              return Yii::$app->taskService->canManage($model->project, Yii::$app->user->identity);
            },
          'take' =>
            function (Task $model, $key, $index) {
              return Yii::$app->taskService->canTake($model, Yii::$app->user->identity);
            },
          'complete' =>
            function (Task $model, $key, $index) {
              return Yii::$app->taskService->canComplete($model, Yii::$app->user->identity);
            },
        ],
      ],
    ],
  ]); ?>

  <?php Pjax::end(); ?>

</div>
