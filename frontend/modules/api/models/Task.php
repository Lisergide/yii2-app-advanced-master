<?php

namespace frontend\modules\api\models;

use common\models\Project;
use yii\helpers\StringHelper;

/**
 * Class Task
 * @package frontend\modules\api\models
 * @property Project $project
 */
class Task extends \common\models\Task
{

    public function fields()
    {
        return [
            'id',
            'title',
            'description_short' => function () {
                return StringHelper::truncate($this->description,50);
            },
        ];
    }

    public function extraFields()
    {
        return [self::RELATION_TASKS_PROJECT];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }
}