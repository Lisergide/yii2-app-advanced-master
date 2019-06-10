<?php

namespace common\services;

use common\models\Project;
use common\models\ProjectUser;
use common\models\Task;
use common\models\User;
use yii\base\Component;
use yii\base\Event;

class AssignTaskEvent extends Event {

  /** @var Task */
  public $task;

  /** @var User */
  public $user;
}

class TaskService extends Component {

  const EVENT_ASSIGN_TASK = 'event_assign_task';
  const EVENT_COMPLETE_TASK = 'event_complete_task';

  /**
   * @param Task $task
   * @param User $user
   */
  public function assignTask(Task $task, User $user) {
      $event = new AssignTaskEvent();
      $event->task = $task;
      $event->user = $user;
      $this->trigger(self::EVENT_ASSIGN_TASK, $event);
  }

  /**
   * @param Task $task
   * @param User $user
   */
  public function completeTaskEvent(Task $task, User $user) {
    $event = new AssignTaskEvent();
    $event->task = $task;
    $event->user = $user;
    $this->trigger(self::EVENT_COMPLETE_TASK, $event);
  }

  /**
   * @param Project $project
   * @param User $user
   * @return bool
   */
  public function canManage(Project $project, User $user) {
    return \Yii::$app->projectService->hasRole($project, $user, ProjectUser::ROLE_MANAGER);
  }

  /**
   * @param Task $task
   * @param User $user
   * @return bool
   */
  public function canTake(Task $task, User $user) {
    return \Yii::$app->projectService->hasRole($task->project, $user, ProjectUser::ROLE_DEVELOPER)
      && (!$task->executor_id);
  }

  /**
   * @param Task $task
   * @param User $user
   * @return bool
   */
  public function canComplete(Task $task, User $user) {
    return ($task->executor_id === $user->id) && (!$task->completed_at);
  }

  /**
   * @param Task $task
   * @param User $user
   * @return bool
   */
  public function takeTask(Task $task, User $user) {
    $task->started_at = time();
    $task->executor_id = $user->id;
    return $task->save();
  }

  /**
   * @param Task $task
   * @return bool
   */
  public function completeTask(Task $task) {
    $task->completed_at = time();
    return $task->save();
  }

}