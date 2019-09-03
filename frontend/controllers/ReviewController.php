<?php

namespace frontend\controllers;

use Yii;
use backend\modules\jeb\models\Article;
use frontend\models\ReviewSearch;
use backend\modules\jeb\models\ArticleReviewer;
use backend\modules\jeb\models\UserScope;
use common\models\Upload;
use yii\db\Expression;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use raoul2000\workflow\validation\WorkflowScenario;
use common\models\Model;
use common\models\UserToken;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;



class ReviewController extends \yii\web\Controller
{
	

	public function behaviors()
		{
			return [
				'access' => [
					'class' => AccessControl::className(),
					'rules' => [
						[
							'allow' => true,
							'roles' => ['@'],
						],
					],
				],
			];
		}

    public function actionIndex()
    {

        $searchModel = new ReviewSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	
	public function actionReviewConfirm($id){
		$review = $this->findReviewer($id);
		$model = $review->article;
		
		
		return $this->render('review_confirm', [
            'model' => $model,
			'review' => $review,
        ]);
	}
	
	public function actionReviewAccept($id){
		
		$accept = $this->findReviewer($id);
		$model = $accept->article;
		//check the user
		if($accept->user_id = Yii::$app->user->identity->id){
			$accept->review_at = new Expression('NOW()');
			$accept->status = 10;
			if($accept->save()){
					$model->sendReviewerEmail(Yii::$app->user->identity, 'Appointment-reviewer-accepted');
					
					Yii::$app->session->addFlash('success', "Thank you, you now have access to review this manuscript.");
					return $this->redirect(['review-form', 'id' => $id]);
				}else{
					$accept->flashError();

				}
		}else{
			 throw new NotFoundHttpException('The requested page does not exist.');

		}
	}
	
	public function actionReviewReject($id){
		
		$accept = $this->findReviewer($id);
		$model = $accept->article;
		//check the user
		if($accept->user_id = Yii::$app->user->identity->id){
				$accept->reject_at = new Expression('NOW()');
				$accept->status = 30;
				if($accept->save()){
					Yii::$app->session->addFlash('success', "Thank you, your withdrawal has been successfully recorded.");
					return $this->redirect('index');
				}
		}else{
			 throw new NotFoundHttpException('The requested page does not exist.');

		}
	}
	
	public function actionReviewCompleted($id){
		if(!$this->canReview($id, 20)){
			 throw new NotFoundHttpException('The requested page does not exist..');
		}
		
		$review = $this->findReviewer($id);
		$model = $review->article;
		
		return $this->render('review_completed', [
            'model' => $model,
			'review' => $review
        ]);
		
	}
	
	public function actionReviewForm($id){
		if(!$this->canReview($id)){
			 throw new NotFoundHttpException('The requested page does not exist..');
		}
		$review = $this->findReviewer($id);
		if($review->status == 20){
			return $this->redirect(['review/review-completed', 'id' => $id]);
		}
		$model = $review->article;
		
		if($review->load(Yii::$app->request->post())){
			$wfaction = Yii::$app->request->post('wfaction');
			if($wfaction=='save'){
				if($review->save()){
					Yii::$app->session->addFlash('success', "Your work has been successfully saved. Please submit your review once it's ready, thank you.");
				}
			}else if($wfaction=='submit'){
				$review->scenario = 'review';
				$review->completed_at = new Expression('NOW()');
				$review->status = 20;
				if($review->save()){
					//maybe email appreciation
					$model->sendReviewerEmail(Yii::$app->user->identity, 'Appreciate-reviewer');
					
					//if no other in progress
					if(!$model->checkInProgressReviewers()){
						$model->sendEmail('After-all-reviewers-finished');
					}
					Yii::$app->session->addFlash('success', "Thank you, your review has been successfully submitted.");
					return $this->redirect('index');
				}else{
					$review->flashError();
				}
			}
			
		}
		
		return $this->render('review_form', [
            'model' => $model,
			'review' => $review
        ]);
	}

	
	protected function canReview($id, $status = false){
		$arr = ['id' => $id, 'user_id' => Yii::$app->user->identity->id];
		if($status){
			$arr['status'] = $status;
		}
		$r = ArticleReviewer::findOne($arr);
		if($r){
			return true;
		}
		return false;
	}
	
	
	
	public function actionUpload($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findReviewer($id);
        $model->file_controller = 'review';

        return Upload::upload($model, $attr, 'review_at');

    }
	
	/**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	 protected function findReviewer($id)
    {
        if (($model = ArticleReviewer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionDownload($attr, $id, $identity = true){
		$attr = $this->clean($attr);
        $model = $this->findReviewer($id);
		$filename = strtoupper($attr);
		Upload::download($model, $attr, $filename);
	}
	
	public function actionDownloadReviewFile($id){
		$attr = 'review';
        $model = $this->findModel($id);
		$filename = strtoupper($attr);
		Upload::download($model, $attr, $filename);
	}
	
	public function actionDelete($attr, $id)
	{
		$attr = $this->clean($attr);
        $model = $this->findReviewer($id);
		$attr_db = $attr . '_file';
		
		$file = Yii::getAlias('@upload/' . $model->{$attr_db});
		
		$model->scenario = $attr . '_delete';
		$model->{$attr_db} = '';
		$model->review_at = new Expression('NOW()');
		if($model->save()){
			if (is_file($file)) {
				unlink($file);
				
			}
			
			return Json::encode([
						'good' => 1,
					]);
		}else{
			return Json::encode([
						'errors' => $model->getErrors(),
					]);
		}
		

	}
	
	protected function clean($string){
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
	}
	
	public function actionListReviewers($scope){
		$reviewers = UserScope::listReviewers($scope);
		
		return Json::encode($reviewers);
		
	}

}
