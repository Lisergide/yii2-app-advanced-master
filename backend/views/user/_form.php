<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
/* @mixin getThumbUploadUrl */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'layout' => 'horizontal',
            'fieldConfig' => [
                'horizontalCssClasses' => ['label' => 'col-sm-2',]
            ],
        ]); ?>

    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'status')->dropDownList(\common\models\User::STATUS_LABELS) ?>

    <?= $form->field($model, 'avatar')
        ->fileInput(['accept' => 'image/*'])
        ->label('Avatar<br>' . Html::img($model->getThumbUploadUrl('avatar', \common\models\User::AVATAR_PREVIEW))) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success m_left']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
