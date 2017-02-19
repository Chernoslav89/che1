<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserSearch extends User
{
    // redefined methods

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'fullname', 'tel', 'photo', 'created_at', 'updated_at'], 'safe'],
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
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
        if (!empty($params[$this->formName()]['updated_at'])) {
            $updated_at = array_diff(array_map('trim', explode('-', $params[$this->formName()]['updated_at'])), ['', 0, null]);
            if (count($updated_at) > 1) {
                $query->andFilterWhere(['between', 'updated_at', strtotime($updated_at[0]), strtotime($updated_at[1])]);
            } else {
                $query->andFilterWhere(['between', 'updated_at', strtotime($updated_at[0]), strtotime($updated_at[0] . ' +1 days')]);
            }
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'fullname', $this->fullname])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'photo', $this->photo]);

        return $dataProvider;
    }
}
