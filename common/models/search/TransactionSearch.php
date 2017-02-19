<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Transaction;

/**
 * TransactionSearch represents the model behind the search form about `common\models\Transaction`.
 */
class TransactionSearch extends Transaction
{
    // redefined methods

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'manager_id', 'user_id', 'type', 'status', 'created_at'], 'integer'],
            [['value'], 'number'],
            [['comment'], 'safe'],
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
        $query = Transaction::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($params[$this->formName()]['created_at'])) {
            $created_at = array_diff(array_map('trim', explode('-', $params[$this->formName()]['created_at'])), ['', 0, null]);
            if (count($created_at) > 1) {
                $query->andFilterWhere(['between', 'created_at', strtotime($created_at[0]), strtotime($created_at[1])]);
            } else {
                $query->andFilterWhere(['between', 'created_at', strtotime($created_at[0]), strtotime($created_at[0] . ' +1 days')]);
            }
        }
        /*/
        if (!empty($params[$this->formName()]['updated_at'])) {
            $updated_at = array_diff(array_map('trim', explode('-', $params[$this->formName()]['updated_at'])), ['', 0, null]);
            if (count($updated_at) > 1) {
                $query->andFilterWhere(['between', 'updated_at', strtotime($updated_at[0]), strtotime($updated_at[1])]);
            } else {
                $query->andFilterWhere(['between', 'updated_at', strtotime($updated_at[0]), strtotime($updated_at[0] . ' +1 days')]);
            }
        }
        /**/
        $query->andFilterWhere([
            'id' => $this->id,
            'manager_id' => $this->manager_id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'value' => $this->value,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
