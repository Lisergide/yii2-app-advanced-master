<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Project */
/* @var $form yii\widgets\ActiveForm */
/* @var $user_id \backend\controllers\ProjectController */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'active')->dropDownList(\common\models\Project::STATUSES_LABELS) ?>

    <?php if (!$model->isNewRecord) { ?>

        <?= $form->field($model, \common\models\Project::RELATION_PROJECT_USERS)
            ->widget(\unclead\multipleinput\MultipleInput::class, [
                // https://github.com/unclead/yii2-multiple-input/wiki/Usage
                'id' => 'project-users-widget',
                'max' => 10,
                'min' => 0,
                'addButtonPosition' => \unclead\multipleinput\MultipleInput::POS_HEADER,
                'columns' => [
                    [
                        'name' => 'project_id',
                        'type' => 'hiddenInput',
                        'defaultValue' => $model->id,
                    ],
                    [
                        'name' => 'user_id',
                        'type' => 'dropDownList',
                        'title' => 'User',
                        'items' => $user_id,
                    ],
                    [
                        'name' => 'role',
                        'type' => 'dropDownList',
                        'title' => 'Role',
                        'items' => \common\models\ProjectUser::ROLE_LABELS,
                    ],
                ],
            ]);
        ?>
    <?php } ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
