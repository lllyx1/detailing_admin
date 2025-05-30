<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use app\models\Resume;
use yii\widgets\MaskedInput;
/* @var $this yii\web\View */
/* @var $model app\models\Resume */
/* @var $form yii\bootstrap4\ActiveForm */

?>

<div class="resume-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'age')->widget(DatePicker::class, [
        'options' => ['placeholder' => 'Выберите дату и время'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd', // Формат даты и времени
        ]
    ]) ?>

    <?php
    try {
        echo $form->field($model, 'photos[]')->widget(FileInput::class, [
            'options' => ['accept' => 'image/*', 'multiple' => true],
        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    ?>
    <?= $form->field($model, 'city_id')->dropDownList(Resume::getCityList(), ['prompt' => 'Выберите город']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
        'mask' => '+7 (999) 999-99-99',
        'options' => [
            'class' => 'form-control',
            'placeholder' => '+7 (___) ___-__-__'
        ]
    ]) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
