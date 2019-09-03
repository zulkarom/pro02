<?php

namespace frontend\controllers;

use Yii;
use backend\modules\jeb\models\Article;
use frontend\models\EditingSearch;
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



class EditingController extends \yii\web\Controller
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

        $searchModel = new EditingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionProofread($id)
    {
		$model = $this->findModel($id);
		if($model->proof_reader == Yii::$app->user->identity->id){
			$model->scenario = WorkflowScenario::enterStatus('ma-finalise');
			if ($model->load(Yii::$app->request->post())) {
				
				$model->finalise_at = new Expression('NOW()');

				$model->sendToStatus('ma-finalise');
				
				if($model->save()){
					$model->sendEmail();
					Yii::$app->session->addFlash('success', "Proofread file has been successfully sent.");
					return $this->redirect('index');
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
					
					return $this->redirect(['proofread', 'id' => $id]);

				}

			}
			
			return $this->render('proofread', [
				'model' => $model,
			]);
			
		}else{
			 throw new NotFoundHttpException('The requested page does not exist.');
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
	
	public function actionUpload($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'editing';

        return Upload::upload($model, $attr, 'updated_at');

    }
	
	public function actionDownload($attr, $id, $identity = true){
		$attr = $this->clean($attr);
        $model = $this->findModel($id);
		$filename = strtoupper($attr);
		Upload::download($model, $attr, $filename);
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
	
	protected function clean($string){
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
	}


}
