<?php

use common\models\User;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

  <?= Html::img($model->getThumbUploadUrl('avatar', \common\models\User::AVATAR_PREVIEW), ['style' => 'margin-bottom: 10px;']) ?>

    <p>
      <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
      <?= Html::a('Edit Profile', ['profile', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
      <?= Html::a('Delete', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
          'confirm' => 'Are you sure you want to delete this item?',
          'method' => 'post',
        ],
      ]) ?>
    </p>

  <?= DetailView::widget([
    'model' => $model,
    'attributes' => [
      'id',
      'username',
      'auth_key',
      'access_token',
      'password_hash',
      'password_reset_token',
      'email:email',
      'avatar',
      [
        'attribute' => 'status',
        'value' => function (common\models\User $model) {
          return \common\models\User::STATUS_LABELS[$model->status];
        }
      ],
      'created_at:datetime',
      'updated_at:datetime',
      'verification_token',
    ],
  ]) ?>

  <?= GridView::widget(
    [
      'dataProvider' => $dataProvider,
      'columns' =>
        [
          [
            'label' => 'Project',
            'format' => 'html',
            'value' => function (\common\models\ProjectUser $model) {
              return Html::a($model->project->title, ['project/view/', 'id' => $model->project_id]);
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
