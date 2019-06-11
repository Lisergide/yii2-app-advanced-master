<?php

namespace common\services;

use common\models\Project;
use common\models\User;
use yii\base\Component;
use yii\base\Event;

class AssignRoleEvent extends Event {
  /** @var Project */
  public $project;
  /** @var User */
  public $user;
  /** @var string */
  public $role;

  public function dump() {
    return ['project' => $this->project->id, 'user' => $this->user->id, 'role' => $this->role];
  }
}

class ProjectService extends Component {
  const EVENT_ASSIGN_ROLE = 'event_assign_role';

  /**
   * @param Project $project
   * @param User $user
   * @param string $role
   */
  public function assignRole(Project $project, User $user, $role) {
    $event = new AssignRoleEvent();
    $event->project = $project;
    $event->user = $user;
    $event->role = $role;
    $this->trigger(self::EVENT_ASSIGN_ROLE, $event);
  }

  /**
   * @param Project $project
   * @param User $user
   * @return mixed
   */
  public function getRoles(Project $project, User $user) {
    return $project->getProjectUsers()->byUser($user->id)->select('role')->column();
  }

  /**
   * @param Project $project
   * @param User $user
   * @param $role
   * @return bool
   */
  public function hasRole(Project $project, User $user, $role) {
    return in_array($role, $this->getRoles($project, $user));
  }
}