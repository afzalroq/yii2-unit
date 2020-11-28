<?php

use afzalroq\unit\entities\Categories;
use afzalroq\unit\entities\Units;

/* @var $this yii\web\View */
/* @var $model Categories */
/* @var $units Units */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-categories-create">

    <?= $this->render('_units_form', [
        'model' => $model,
        'units' => $units,
    ]) ?>

</div>
