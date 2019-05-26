<?php

namespace frontend\modules\api\models;

class Project extends \common\models\Project
{
    public function fields()
    {
        return [
            'id',
            'title',
            'description_short' => function () {
                return substr($this->description, 0, 50);
            },
            'active'
        ];
    }

    public function extraFields()
    {
        return [self::RELATION_TASKS_PROJECT_ID];
    }

}