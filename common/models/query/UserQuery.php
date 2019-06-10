<?php


namespace common\models\query;


use common\models\User;

class UserQuery extends \yii\db\ActiveQuery {

  /**
   * @return $this
   */
  public function onlyActive() {
      $this->andWhere(['status' => User::STATUS_ACTIVE]);
      return $this;
  }
}