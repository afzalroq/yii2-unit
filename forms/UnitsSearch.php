<?php

namespace afzalroq\unit\forms;

use afzalroq\unit\entities\Categories;
use afzalroq\unit\entities\Units;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UnitsSearch extends Units
{

    public function rules()
    {
        return [];
    }


    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $slug)
    {
        $category = Categories::findOne(['slug' => $slug]);
        $query = Units::find()->where(['category_id' => $category->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'sort' => SORT_ASC
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        return $dataProvider;
    }

}
