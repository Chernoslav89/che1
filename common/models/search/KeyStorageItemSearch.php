<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\KeyStorageItem;

/**
 * KeyStorageItemSearch represents the model behind the search form about `common\models\KeyStorageItem`.
 */
class KeyStorageItemSearch extends KeyStorageItem
{
    // redefined methods

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'value', 'comment'], 'safe'],
            [['updated_at', 'created_at'], 'integer'],
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
     * @param string|null $formName
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = KeyStorageItem::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
