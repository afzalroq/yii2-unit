<?php

use afzalroq\unit\forms\UnitSearch;
use afzalroq\unit\entities\Unit;
use afzalroq\unit\entities\Categories;
use yii\grid\GridView;
use yii\helpers\Html;
use afzalroq\unit\helpers\Type;

/* @var $this yii\web\View */
/* @var $searchModel UnitSearch */
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
                'value' => function (Unit $model) use ($category) {
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
