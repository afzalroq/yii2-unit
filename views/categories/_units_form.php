<?php

use afzalroq\unit\entities\Unit;
use afzalroq\unit\helpers\Type;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use afzalroq\unit\entities\Categories;

/* @var $this View */
/* @var $units Unit */
/* @var $model Categories */
/* @var $form ActiveForm */
?>

<div class="box">
    <div class="box-body">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
        <?= $form->errorSummary($units) ?>
        <div class="row">
            <?php
            foreach ($units as $unit) {
                foreach (Yii::$app->params['cms']['languages2'] as $key => $language) {
                    if (in_array($unit->type, [Type::TEXT_COMMON, Type::STRING_COMMON, Type::IMAGE_COMMON, Type::FILE_COMMON, Type::INPUT_COMMON])) {
                        echo '<div class="col-sm-' . $unit->size . '">' . ($unit->getModelByType())->getFormField($form, $key, '') . '</div>';
                        break;
                    }
                    if (!in_array($unit->type, [Type::TEXT_COMMON, Type::STRING_COMMON, Type::IMAGE_COMMON, Type::FILE_COMMON, Type::INPUT_COMMON])) {
                        echo '<div class="col-sm-' . $unit->size . '">' . ($unit->getModelByType())->getFormField($form, $key, $language) . '</div>';
                    }
                }
            }
            ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton(Yii::t('block', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
