<?php

namespace frontend\modules\api\models;

use common\models\Task;
use yii\helpers\StringHelper;

class Project extends \common\models\Project
{
    public function fields()
    {
        return [
            'id',
            'title',
            'description_short' => function () {
                return StringHelper::truncate($this->description, 50);
            },
            'active'
        ];
    }

    public function extraFields()
    {
        return [self::RELATION_TASKS_PROJECT_ID];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['project_id' => 'id']);
    }

}