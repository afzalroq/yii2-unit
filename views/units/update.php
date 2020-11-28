<?php

use afzalroq\unit\entities\Categories;
use afzalroq\unit\entities\Units;

/* @var $this yii\web\View */
/* @var $model Blocks */
/* @var $category Categories */

$this->title = Yii::t('block', 'Update');
$this->params['breadcrumbs'][] = ['label' => Yii::t('block','Units'), 'url' => ['index', 'slug' => $category->slug]];
$this->params['breadcrumbs'][] = ['label' => $model->label, 'url' => ['view', 'id' => $model->id, 'slug' => $category->slug]];
$this->params['breadcrumbs'][] = Yii::t('block', 'Update');
?>
<div class="articles-update">

    <?= $this->render('_form', [
        'model' => $model,
        'category' => $category
    ]) ?>

</div>
