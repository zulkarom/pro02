<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use backend\modules\jeb\models\ReviewForm;
use yii\widgets\ActiveForm;
use common\models\Upload;


/* @var $this yii\web\View */
/* @var $model common\models\Article */

?>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'keyword',
            'abstract:ntext',
			[
				'label' => 'Review Status',
				'format' => 'html',
				'value' => function($model){
					return $model->myReview->getStatusLabel(true);
		
					
				}
			],
			[
				'label' => 'Manuscript Status',
				'format' => 'html',
				'value' => function($model){
					return $model->wfLabel;
					
				}
			],
			[
				'attribute' => 'review_file',
				'format' => 'raw',
				'visible' => $vis,
				'value' => function($model){
					return '<a href="'. Url::to(['review/download-review-file', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> REVIEW FILE</a>';
				}
			],
        ],
    ]) ?>
	
