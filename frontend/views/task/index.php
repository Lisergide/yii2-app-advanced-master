<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $projects [] */
/* @var $activeUsers [] */

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
        'value' => function (\common\models\Task $model) {
          return Html::a($model->project->title, ['project/view', 'id' => $model->project->id]);
        },
        'format' => 'html',
      ],
      'title',
      'description:ntext',
      [
        'attribute' => 'executor_id',
        'label' => 'Executor',
        'filter' => $activeUsers,
        'value' => function(\common\models\Task $model) {
            return Html::a($model->executor->username, ['user/view', 'id' => $model->executor_id]);
        }
      ],
      'started_at:datetime',
      'completed_at:datetime',
      'creator.username',
      'updater.username',
      'created_at:datetime',
      'updated_at:datetime',
    ],
    [
      'class' => 'yii\grid\ActionColumn',
      'template' => '{view} {update} {delete} {take} {completed}',
      'buttons' => [
        'take' => function ($url, \common\models\Task $model, $key) {
          $icon = \yii\bootstrap\Html::icon('plus');
          return Html::a($icon, ['task/take', 'id' => $model->id], ['data' => [
            'confirm' => 'Взять задачу?',
            'method' => 'post',
          ]]);
        },
        'completed' => function ($url, \common\models\Task $model, $key) {
          $icon = \yii\bootstrap\Html::icon('ok');
          return Html::a($icon, ['task/complete', 'id' => $model->id], ['data' => [
            'confirm' => 'Завершить задачу?',
            'method' => 'post',
          ]]);
        }
      ],
      'visibleButtons' => [
        'update' =>
          function (\common\models\Task $model, $key, $index) {
            return Yii::$app->taskService->canManage($model->project, Yii::$app->user->identity);
          },
        'delete' =>
          function (\common\models\Task $model, $key, $index) {
            return Yii::$app->taskService->canManage($model->project, Yii::$app->user->identity);
          },
        'take' =>
          function (\common\models\Task $model, $key, $index) {
            return Yii::$app->taskService->canTake($model, Yii::$app->user->identity);
          },
        'completed' =>
          function (\common\models\Task $model, $key, $index) {
            return Yii::$app->taskService->canComplete($model, Yii::$app->user->identity);
          },
      ],
    ],
  ]); ?>

  <?php Pjax::end(); ?>

</div>
