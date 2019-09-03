<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\jeb\models\Journal;

/**
 * ArchiveSearch represents the model behind the search form of `backend\modules\jeb\models\Journal`.
 */
class ArchiveSearch extends Journal
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'volume', 'issue', 'status', 'is_special'], 'integer'],
            [['journal_name', 'description', 'published_at', 'archived_at'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Journal::find()->orderBy('volume DESC, issue DESC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			//'sort'=> ['defaultOrder' => ['status'=>SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'status' => 30,
        ]);

        $query->andFilterWhere(['like', 'journal_name', $this->journal_name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
