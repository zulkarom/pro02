<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use dosamigos\chartjs\ChartJs;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles';

$this->params['breadcrumbs'][] = $this->title;

?>


<div class="block-content">

		<div class="container">
			<div class="row">
				<div class="col-md-2">
					<p>
        <?= Html::a('New Submission', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
				</div>
				<div class="col-md-8">
					<h2 class="section_title text-center">LIST OF SUBMISSION</h2>
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
				'attribute' => 'status',
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
						$status = $model->wfStatus;
						if($status == 'draft'){
							return '<a href="'.Url::to(['/submission/update', 'id' => $model->id]).'" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span> UPDATE</a>';
						}else if($status == 'correction'){
							return '<a href="'.Url::to(['/submission/correction', 'id' => $model->id]).'" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span> CORRECT</a>';
						}else if($status == 'finalise'){
							return '<a href="'.Url::to(['/submission/finalise', 'id' => $model->id]).'" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span> FINALISE</a>';
						}else{
							return '<a href="'.Url::to(['/submission/view', 'id' => $model->id]).'" class="btn btn-warning btn-sm"><span class="fa fa-eye"></span> VIEW</a>';
						}
                        
                    }
                ],
            
            ]

        ],
    ]); ?>
</div>			</div>
</div>
<br /><br />