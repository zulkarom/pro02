<?php

namespace frontend\models;

use Yii;
use backend\modules\jeb\models\Article;

class Stats
{
	public static function mySubmission(){
		return Article::find()
		->where(['user_id' => Yii::$app->user->identity->id])
		->count();
	}
	public static function myReview(){
		return Article::find()
		->joinWith('articleReviewers')
		->where(['jeb_article_reviewer.user_id' => Yii::$app->user->identity->id, 'jeb_article_reviewer.status' => 0 ])
		->count();
	}

}
