<?php

namespace frontend\modules\api\models;

class User extends \common\models\User
{
    public function fields()
    {
        return ['id', 'username', 'email'];
    }

    public function extraFields()
    {
        return ['project'];
    }

}