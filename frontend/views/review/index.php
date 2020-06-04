<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Review';

$this->params['breadcrumbs'][] = $this->title;

?>


<div class="block-content">

		<div class="container">
			<div class="row">
				<div class="col">
					<h2 class="section_title text-center">LIST OF REVIEW</h2>
				</div>

			</div>
			<br /><div class="article-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'options' => [ 'style' => 'table-layout:fixed;' ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn', 'contentOptions' => [ 'style' => 'width: 5%;' ],],

			[
				'attribute' => 'title',
				'contentOptions' => [ 'style' => 'width: 70%;' ]
				
			]
			,
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
			]
			,

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{request}',
                'buttons'=>[
                    'request'=>function ($url, $model) {
						$rid = $model->myReview->id;
						$review_status = $model->myReview->status;
						if($review_status == 0){ //appoint
							return '<a href="'.Url::to(['/review/review-confirm', 'id' => $rid]).'" class="btn btn-warning btn-sm"><span class="fa fa-eye"></span> VIEW</a>';
						}else if($review_status == 10){ // in progress
							return '<a href="'.Url::to(['/review/review-form', 'id' => $rid]).'" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span> REVIEW</a>';
						}else if($review_status == 20 ){//completed
							return '<a href="'.Url::to(['/review/review-completed', 'id' => $rid]).'" class="btn btn-warning btn-sm"><span class="fa fa-eye"></span> VIEW</a>';
						}  
                    }
                ],
            
            ]

        ],
    ]); ?>
</div>			</div>
</div>
<br /><br /><br />