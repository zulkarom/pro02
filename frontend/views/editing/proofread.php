<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use backend\modules\jeb\models\ReviewForm;
use yii\widgets\ActiveForm;
use common\models\Upload;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = 'Manuscript Proofreading';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$status = $model->wfStatus;
?>
<div class="block-content">

		<div class="container">
			<div class="row">
				<div class="col">
					<h2 class="section_title text-center"><?= Html::encode($this->title) ?> </h2>
				</div>

			</div>
			<br /><div class="article-view">

<style>
table.detail-view th {
    width:15%;
}
</style>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'keyword',
            'abstract:ntext',
			[
				'attribute' => 'status',
				'format' => 'html',
				'value' => function($model){
					return $model->wfLabel;
				}
			],
			[
				'attribute' => 'asgn_profrdr_at',
				'label' => 'Assigned At',
				'format' => 'datetime'
			]
            ,
			[
				'attribute' => 'postfinalise_file',
				'format' => 'raw',
				'value' => function($model){
					return '<a href="'. Url::to(['article/download', 'attr' => 'postfinalise', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> FILE</a>';
				}
			],
        ],
    ]) ?>
	
	<br />
	
	<?php 
	
	if($model->isProofReader()){
		if($status == 'proofread'){
			echo $this->render('_form_proofread', [
					'model' => $model,

			]);
		}else{
			echo $this->render('_view_proofread', [
					'model' => $model,

			]);
		}
	}
	
	
	
?>
	

	
	
	



    </div>

 

	
	

</div>
			</div>
</div>

<br /><br /><br />