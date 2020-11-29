<?php

use afzalroq\unit\entities\TextInput;
use afzalroq\unit\entities\Unit;
use afzalroq\unit\helpers\Type;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model Unit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="articles-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'category_id')->hiddenInput(['value' => $category->id])->label(false) ?>

    <?= $form->errorSummary($model) ?>

    <div class="box">
        <div class="box-body row">
            <div class="col-sm-2">
                <?= $form->field($model, 'type')->dropDownList(Type::list(), ['prompt' => '-- -- --']) ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'label')->textInput() ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'slug')->textInput() ?>
            </div>
            <div class="col-sm-2">
                <?php
                $model->size = $model->isNewRecord ? 6 : $model->size;
                echo $form->field($model, 'size')->textInput();
                ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'sort')->textInput(['value' => $model->getSortValue($category->id)]) ?>
            </div>
            <div class="col-sm-2">
                <?= $form->field($model, 'inputValidator')->dropDownList(TextInput::validatorList()) ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('block', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$inputCommon = Type::INPUT_COMMON;
$inputs = Type::INPUTS;

$newScript = <<< JS
    var inputs = $inputs;
    var inputCommon = $inputCommon;
    
    var selectTypes = $('#unit-type');
    var inputValidatorDiv = $('.field-unit-inputvalidator');

    showValidatorInput(selectTypes.val());
    selectTypes.on('change', function () {
        showValidatorInput(this.value);
    });
    
    function showValidatorInput (type) {
        if (type == inputs || type == inputCommon){
            inputValidatorDiv.show();
        } else {
            inputValidatorDiv.hide();
        }
    };
JS;

$this->registerJs(
    $newScript
);

?>
