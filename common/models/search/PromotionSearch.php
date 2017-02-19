<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Promotion;

/**
 * PromotionSearch represents the model behind the search form about `common\models\Promotion`.
 */
class PromotionSearch extends Promotion
{
    // redefined methods

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'published'], 'integer'],
            [['title', 'cover', 'content', 'published_start', 'published_end', 'created_at', 'updated_at'], 'safe'],
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
        $query = Promotion::find();

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
            'type' => $this->type,
            'published' => $this->published,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
