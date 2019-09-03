<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\jeb\models\Article;

/**
 * SearchArticle represents the model behind the search form of `backend\modules\jeb\models\Article`.
 */
class SearchArticle extends Article
{
	public $search_article;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['search_article'], 'required'],
			
			[['title', 'keyword', 'abstract'], 'safe'],
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
	
         $query = Article::find()->where(['status' => 'ArticleWorkflow/qa-publish']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
                'pageSize' => 100,
            ],

			
			
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		
		


        $query->orFilterWhere(['like', 'title', $this->search_article])
            ->orFilterWhere(['like', 'abstract', $this->search_article])
            ->orFilterWhere(['like', 'keyword', $this->search_article])
            ;
			

        return $dataProvider;
    }
}
