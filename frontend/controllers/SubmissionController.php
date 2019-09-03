<?php

namespace frontend\controllers;

use Yii;
use backend\modules\jeb\models\Article;
use backend\modules\jeb\models\ArticleAuthor;
use backend\modules\jeb\models\ArticleStatus;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use raoul2000\workflow\validation\WorkflowScenario;
use common\models\Model;
use yii\helpers\ArrayHelper;
use common\models\Upload;
use yii\helpers\Json;
use yii\filters\AccessControl;
use backend\modules\jeb\models\Setting;
use backend\modules\jeb\models\EmailTemplate;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class SubmissionController extends Controller
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

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
		$query =  Article::find()->where(['user_id' => Yii::$app->user->identity->id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
		
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionShowManuscript(){
		$article = Article::findOne(58);
		echo $article->manuscriptNo();
	}
	
	public function actionWithdraw($id)
    {
		$model = $this->findModel($id);
		
		
		if(!in_array($model->getWorkflowStatus()->getId(), ArticleStatus::canWithdraw())){
			Yii::$app->session->addFlash('error', "Not allowed to withdraw at this stage.");
			return $this->redirect(['index']);
		}
		
		$model->scenario = WorkflowScenario::enterStatus('sa-withdraw-request');
		
		if ($model->load(Yii::$app->request->post())) {
			
        $model->withdraw_request_at = new Expression('NOW()');
		$model->withdraw_at_status = $model->status;
		
		$model->sendToStatus('sa-withdraw-request');
		
        if($model->save()){
			$model->sendEmail();
            Yii::$app->session->addFlash('success', "The request to withdraw the manuscript has been successfully sent.");
			
            
        }else{

			if($model->getErrors()){
				foreach($model->getErrors() as $error){
					if($error){
						foreach($error as $e){
							Yii::$app->session->addFlash('error', $e);
						}
					}
				}
			}
		}
		

		}
		
		return $this->redirect('index');
    }
	
	public function actionFinalise($id)
    {
		$model = $this->findModel($id);
		$model->scenario = WorkflowScenario::enterStatus('oa-camera-ready');
		
		$ori_status = $model->status;
		if ($model->load(Yii::$app->request->post())) {
			
        $model->camera_ready_at = new Expression('NOW()');
		
		$model->sendToStatus('oa-camera-ready');
		
        if($model->save()){
			$model->sendEmail();
            Yii::$app->session->addFlash('success', "The manuscript has been successfully finalised.");
			
            return $this->redirect('index');
        }else{
			$model->status = $ori_status;

			if($model->getErrors()){
				foreach($model->getErrors() as $error){
					if($error){
						foreach($error as $e){
							Yii::$app->session->addFlash('error', $e);
						}
					}
				}
			}
		}

		}
		
		
        return $this->render('finalise', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCorrection($id)
    {
		$model = $this->findModel($id);
		$model->scenario = WorkflowScenario::enterStatus('ia-post-evaluate');
		$authors = $model->articleAuthors;
		
        
        if ($model->load(Yii::$app->request->post())) {
			
			$wfaction = Yii::$app->request->post('wfaction');
			
			/* STATUS CORRECTION */
			$model->correction_at = new Expression('NOW()');
			$model->sendToStatus('ia-post-evaluate');
			
			$oldAuthorIDs = ArrayHelper::map($authors, 'id', 'id');
            
            $authors = Model::createMultiple(ArticleAuthor::classname());
			
            Model::loadMultiple($authors, Yii::$app->request->post());
			
			$deletedAuthorIDs = array_diff($oldAuthorIDs, array_filter(ArrayHelper::map($authors, 'id', 'id')));
            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($authors) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
						
						if (! empty($deletedAuthorIDs)) {
                            ArticleAuthor::deleteAll(['id' => $deletedAuthorIDs]);
                        }
                        
                        foreach ($authors as $indexAu => $author) {
                            
                            if ($flag === false) {
                                break;
                            }

                            $author->article_id = $model->id;

                            if (!($flag = $author->save(false))) {
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
						$model->sendEmail();
                        Yii::$app->session->addFlash('success', "The correction has been successfully sent.");
						return $this->redirect('index');
                    } else {
						
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }
        }
		
		if($model->getErrors()){
			foreach($model->getErrors() as $error){
				if($error){
					foreach($error as $e){
						Yii::$app->session->addFlash('error', $e);
					}
				}
			}
		}
		
		$reviewers = $model->completedReviewers;

		
		
        return $this->render('correction', [
            'model' => $model,
			'reviewers' => $reviewers,
			'authors' => (empty($authors)) ? [new ArticleAuthor] : $authors
			
        ]);
    }
	
	 /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();
		$model->scenario = WorkflowScenario::enterStatus('aa-draft');
		
		
		$authors = [new ArticleAuthor];
        
        if ($model->load(Yii::$app->request->post())) {
			
			$wfaction = Yii::$app->request->post('wfaction');
			
			/* DRAFT STATUS */
			$model->draft_at = new Expression('NOW()');
			$model->sendToStatus('aa-draft');
			
			$model->user_id = Yii::$app->user->identity->id;
			
			$model->manuscript_no = Yii::$app->user->identity->id . '-' . time();
			
            $authors = Model::createMultiple(ArticleAuthor::classname());
			
            Model::loadMultiple($authors, Yii::$app->request->post());
            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($authors) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        
                        foreach ($authors as $indexAu => $author) {
                            
                            if ($flag === false) {
                                break;
                            }

                            $author->article_id = $model->id;

                            if (!($flag = $author->save(false))) {
                                break;
                            }
                        }

                    }
					
                    if ($flag) {
                        $transaction->commit();
						if($wfaction == 'btn-submit'){
							
							return $this->redirect(['upload-article', 'id' => $model->id]);
							
						}else{
							
							return $this->redirect(['update', 'id' => $model->id]);
							
						}
                        
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
			'authors' => (empty($authors)) ? [new ArticleAuthor] : $authors
        ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$model->scenario = WorkflowScenario::enterStatus('aa-draft');
		
		
		$authors = $model->articleAuthors;
        
        if ($model->load(Yii::$app->request->post())) {
			
			$model->draft_at = new Expression('NOW()');
			$wfaction = Yii::$app->request->post('wfaction');
			
			$model->sendToStatus('aa-draft');
			
			$oldAuthorIDs = ArrayHelper::map($authors, 'id', 'id');
            
            $authors = Model::createMultiple(ArticleAuthor::classname());
			
            Model::loadMultiple($authors, Yii::$app->request->post());
			
			$deletedAuthorIDs = array_diff($oldAuthorIDs, array_filter(ArrayHelper::map($authors, 'id', 'id')));
            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($authors) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
						
						if (! empty($deletedAuthorIDs)) {
                            ArticleAuthor::deleteAll(['id' => $deletedAuthorIDs]);
                        }
                        
                        foreach ($authors as $indexAu => $author) {
                            
                            if ($flag === false) {
                                break;
                            }

                            $author->article_id = $model->id;

                            if (!($flag = $author->save(false))) {
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
                        if($wfaction == 'btn-submit'){
							return $this->redirect(['upload-article', 'id' => $model->id]);
						}else{
							return $this->redirect(['update', 'id' => $model->id]);
						}
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
			'authors' => (empty($authors)) ? [new ArticleAuthor] : $authors
        ]);
    }
	
	/**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUploadArticle($id)
    {
        $model = $this->findModel($id);
		$model->scenario = WorkflowScenario::enterStatus('ba-pre-evaluate');
        
        if ($model->load(Yii::$app->request->post())) {
			$wfaction = Yii::$app->request->post('wfaction');
			
			if($wfaction == 'btn-submit'){
				
				/* PRE-EVALUATE */
				$model->submit_at = new Expression('NOW()');
				$model->sendToStatus('ba-pre-evaluate');
				$model->manuscript_no = $model->id;
				
				if($model->save()){
					$model->sendEmail();
					$model->sendEmail('Author-submission');
					return $this->redirect(['index']);
					
				}else{
					if($model->getErrors()){
						foreach($model->getErrors() as $error){
							if($error){
								foreach($error as $e){
									Yii::$app->session->addFlash('error', $e);
								}
							}
						}
					}

				}
				
			}else{
				Yii::$app->session->addFlash('success', "Data saved.");
				return $this->redirect(['upload-article', 'id' => $model->id]);
			}
			
        }

        return $this->render('upload', [
            'model' => $model
        ]);
    }
	
	public function actionUpload($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'submission';

        return Upload::upload($model, $attr, 'updated_at');

    }
	
	protected function clean($string){
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
	}


    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteArticle($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
	public function actionDelete($attr, $id)
	{
		$attr = $this->clean($attr);
        $model = $this->findModel($id);
		$attr_db = $attr . '_file';
		
		$file = Yii::getAlias('@upload/' . $model->{$attr_db});
		
		$model->scenario = $attr . '_delete';
		$model->{$attr_db} = '';
		$model->updated_at = new Expression('NOW()');
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
	
	public function actionDownload($attr, $id, $identity = true){
		$attr = $this->clean($attr);
        $model = $this->findModel($id);
		$filename = strtoupper($attr);
		Upload::download($model, $attr, $filename);
	}
	
	public function actionDownloadTemplate(){
        $attr = 'template';
        $model = Setting::findOne(1);
        $filename = strtoupper($attr);
        
        
        
        Upload::download($model, $attr, $filename);
    }
}
