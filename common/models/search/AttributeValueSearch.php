<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AttributeValue;

/**
 * AttributeValueSearch represents the model behind the search form about `common\models\AttributeValue`.
 */
class AttributeValueSearch extends AttributeValue
{
    // redefined methods

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'attribute_id'], 'integer'],
            [['value'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    // custom methods

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AttributeValue::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'product_id' => $this->product_id,
            'attribute_id' => $this->attribute_id,
        ]);

        $query->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }
}
