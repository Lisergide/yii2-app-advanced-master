<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $task common\models\Task */

?>
<div>
    <p>Привет <?= Html::encode($user->username) ?>, </p>
    <p>В проекте <?= Html::encode($task->project->title) ?> разработчик <?= $task->executor->username ?> взял задачу
      <?= $task->title ?></p>
</div>
