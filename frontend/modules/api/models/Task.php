<?php

namespace frontend\modules\api\models;

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
            return substr($this->description, 0, 50);
        },
            ];
    }

    public function extraFields()
    {
        return [self::RELATION_TASKS_PROJECT];
    }
}