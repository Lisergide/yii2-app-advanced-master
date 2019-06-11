<?php


namespace common\models\query;


use common\models\ProjectUser;
use common\models\User;

class UserQuery extends \yii\db\ActiveQuery {

  /**
   * @return $this
   */
  public function onlyActive() {
      $this->andWhere(['status' => User::STATUS_ACTIVE]);
      return $this;
  }

  /**
   * @param $userId integer
   * @return UserQuery
   */
  public function allUsersByProject($userId)
  {
    $query = ProjectUser::find()->usersByProject($userId)->select('user_id');
    return $this->andWhere(['id' => $query]);
  }
}