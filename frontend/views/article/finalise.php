<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = 'Finalise Manuscript';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;




?>



<div style="margin-top:10px">

		<div class="container">
			<div class="row">
				<div class="col">
					<h2 class="section_title text-center"><?= Html::encode($this->title) ?> </h2>
				</div>

			</div>
			<br /><div class="article-view">


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
				'attribute' => 'pre_evaluate_at',
				'label' => 'Sumission Time',
				'format' => 'datetime'
			]
            ,
			[
				'attribute' => 'galley_file',
				'format' => 'raw',
				'value' => function($model){
					return '<a href="'. Url::to(['article/download', 'attr' => 'galley', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> GALLEY FILE</a>';
				}
			],
        ],
    ]) ?>

	

	<?=$this->render('_finalise_form', [
			'model' => $model,

	]);
?>
	

</div>
</div>



</div>