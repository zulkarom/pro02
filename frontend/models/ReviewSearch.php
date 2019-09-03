<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\jeb\models\Article;

/**
 * ArticleSearch represents the model behind the search form of `common\models\Article`.
 */
class ReviewSearch extends Article
{
	public $str_search;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
		
		
        return [
		
            [['str_search'], 'string'],
			
            [['str_search'], 'safe'],
			
			
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
        $query = Article::find();
		$query->joinWith('articleReviewers');

        // add conditions that should always apply here

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
			'jeb_article_reviewer.user_id' => Yii::$app->user->identity->id,
			'jeb_article_reviewer.status' => [0, 10, 20, 30] //appoint-review-complete
        ]);

        $query->andFilterWhere(['like', 'title', $this->str_search])
            ->andFilterWhere(['like', 'keyword', $this->str_search])
            ->andFilterWhere(['like', 'abstract',$this->str_search]);

        return $dataProvider;
    }
}
