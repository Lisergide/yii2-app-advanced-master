<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

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

            'project.title',
            'title',
            'description:ntext',
            'executor.username',
            'started_at:datetime',
            'completed_at:datetime',
            'creator.username',
            'updater.username',
            'created_at:datetime',
            'updated_at:datetime',
        ],
        /*[
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {delete} {take}',
            'buttons' => [
                'take' => function ($url, \common\models\Task $model, $key) {
                    $icon = \yii\bootstrap\Html::icon('hand-right');
                    return Html::a($icon, ['task/take', 'id' => $model->id], ['data' => [
                        'confirm' => 'Берете задачу?',
                        'method' => 'post',
                    ],]);
                },
            ],
            'visibleButtons' => [
                'update' =>
                    function (\common\models\Task $model, $key, $index) {
                        return Yii::$app->projectService->hasRole($model->project, Yii::$app->user->identity,
                            \common\models\ProjectUser::ROLE_MANAGER);
                    },
                'delete' =>
                    function (\common\models\Task $model, $key, $index) {
                        return Yii::$app->projectService->hasRole($model->project, Yii::$app->user->identity,
                            \common\models\ProjectUser::ROLE_MANAGER);
                    },
                'take' =>
                    function (\common\models\Task $model, $key, $index) {
                        return Yii::$app->projectService->hasRole($model->project, Yii::$app->user->identity,
                            \common\models\ProjectUser::ROLE_DEVELOPER);
                    },
            ]
        ],*/
    ]); ?>

    <?php Pjax::end(); ?>

</div>
