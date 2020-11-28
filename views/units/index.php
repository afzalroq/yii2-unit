<?php

use afzalroq\unit\forms\UnitsSearch;
use afzalroq\unit\entities\Units;
use afzalroq\unit\entities\Categories;
use yii\grid\GridView;
use yii\helpers\Html;
use afzalroq\unit\helpers\Type;

/* @var $this yii\web\View */
/* @var $searchModel UnitsSearch */
/* @var $category Categories */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $category->title;
$this->params['breadcrumbs'][] = ['label' => $category->title, 'url' => ['/unit/categories/view', 'id' => $category->id]];
?>
<div class="articles-index">

    <p>
        <?= Html::a(Yii::t('block', 'Create'), ['create', 'slug' => $category->slug], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('block', 'Categories'), ['categories/index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'sort',
            [
                'attribute' => 'label',
                'value' => function (Units $model) use ($category) {
                    return Html::a($model->label, ['view', 'id' => $model->id, 'slug' => $category->slug]);
                },
                'format' => 'raw'
            ],
            'slug',
            [
                'attribute' => 'type',
                'value' => function ($model) {
                    return Type::name($model->type);
                }
            ],
            'size',
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]); ?>
</div>
