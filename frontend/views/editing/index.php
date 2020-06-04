<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Editing';

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="block-content">

		<div class="container">
			<div class="row">
				<div class="col">
					<h2 class="section_title text-center">EDITING</h2>
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
						if($status == 'proofread' and $model->isProofReader()){
							return '<a href="'.Url::to(['/editing/proofread', 'id' => $model->id]).'" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span> PROOFREAD</a>';
						}else{
							return '<a href="'.Url::to(['/editing/proofread', 'id' => $model->id]).'" class="btn btn-warning btn-sm"><span class="fa fa-eye"></span> VIEW</a>';
						}
							
                        
                    }
                ],
            
            ]

        ],
    ]); ?>
</div>			</div>
</div>
