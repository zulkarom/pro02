<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = 'Manuscript Correction';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;




?>



<div class="block-content">

		<div class="container">
			<div class="row">
				<div class="col">
					<h2 class="section_title text-center"><?= Html::encode($this->title) ?> </h2>
					<br  />
					* Please be informed that the committees have regarded your manuscript submission as (<?=$model->evaluateOption?>).<br />*Please consider all notes from reviewers and resubmit according to the template provided below.
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
				'attribute' => 'submission_file',
				'label' => 'Manuscript File',
				'format' => 'raw',
				'value' => function($model){
					return '<a href="'. Url::to(['submission/download', 'attr' => 'submission', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> MANUSCRIPT</a> <br />
					* this is your original submission file.
					
					';
				}
			],
			[
				'label' => 'Template File',
				'format' => 'raw',
				'value' => '<a href="'. Url::to(['submission/download-template']) .'" target="_blank"><i class="fa fa-download"></i> TEMPLATE</a>
					
					'
			],
        ],
    ]) ?>

	
	<?=$this->render('_review_report', [
			'model' => $model,
			'reviewers' => $reviewers
	]);
?>

	<?=$this->render('_correction_form', [
			'model' => $model,
			'authors' => $authors

	]);
?>
	

</div>
</div>



</div>