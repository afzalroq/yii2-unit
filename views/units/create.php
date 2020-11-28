<?php

use afzalroq\unit\entities\Categories;
use afzalroq\unit\entities\Units;

/* @var $this yii\web\View */
/* @var $model Units */
/* @var $category Categories */

$this->title = Yii::t('block', 'Create');
$this->params['breadcrumbs'][] = ['label' => $category->title, 'url' => ['index', 'slug' => $category->slug]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="articles-create">

    <?= $this->render('_form', [
        'model' => $model,
        'category' => $category
    ]) ?>

</div>
