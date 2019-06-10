<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description:ntext',
            [
                'attribute' => 'active',
                'value' => function (\common\models\Project $model) {
                    return \common\models\Project::STATUSES_LABELS[$model->active];
                }
            ],
            'creator_id',
            'updater_id',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

    <?= GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'columns' =>
                [
                    [
                        'label' => 'Username',
                        'format' => 'html',
                        'value' => function (\common\models\ProjectUser $model) {
                            return Html::a($model->user->username, ['user/view', 'id' => $model->user_id]);
                        }

                    ],
                    [
                        'label' => 'Role',
                        'value' => function (\common\models\ProjectUser $model) {
                            return $model->role;
                        }
                    ],

                ],
            'summary' => false,
        ]); ?>

  <?php echo \yii2mod\comments\widgets\Comment::widget([
    'model' => $model,
  ]); ?>

</div>
