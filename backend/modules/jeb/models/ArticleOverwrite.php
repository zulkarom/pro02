<?php

namespace backend\modules\jeb\models;

use Yii;
use common\models\workflows\ArticleWorkflow;

class ArticleOverwrite extends \yii\db\ActiveRecord
{
	public $submission_instance;
	public $review_instance;
	public $correction_instance;
	public $galley_instance;
	public $finalise_instance;
	public $proofread_instance;
	public $cameraready_instance;
	public $postfinalise_instance;
	public $payment_instance;
	public $email_workflow;
	
	public $file_controller;
	
	public $scope_name;
	public $max_yearly;
	
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jeb_article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'title', 'abstract'], 'required'],
			
		
        ];
    }


	
	public function getWfLabel(){
		$status = $this->getWfStatus();
		
		$format = strtoupper($status);
		return $format;
	}
	
	
	public function getWfStatus(){
		$status = $this->status;
		/* $status = str_replace("ArticleWorkflow/","",$status);
		$status = explode('-', $status);
		$status = $status[1]; */
		return substr($status, 19);
	}
	

}
