<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use backend\modules\jeb\models\ReviewForm;
use yii\widgets\ActiveForm;
use common\models\Upload;


/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = 'Manuscript Review';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="block-content">

		<div class="container">
			<div class="row">
				<div class="col">
					<h2 class="section_title text-center"><?= Html::encode($this->title) ?> </h2>
				</div>

			</div>
			<br /><div class="article-view">
<?php 
$vis = $model->myReview->status == 10 ? true : false;
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
					return '<a href="'. Url::to(['submission/download', 'attr' => 'review', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> FILE</a>';
				}
			],
        ],
    ]) ?>
	
	<br />
	

	<?php 
	
	if($review->status == 10){
		echo $this->render('_form_review', [
		'review' => $review
	]);
	}else if($review->status == 20){
		echo $this->render('_view_review', [
		'review' => $review
	]);
	}else if($review->status == 0){
		echo $this->render('_form_accept_review', [
		'accept' => $accept
	]);
	}
	
	
	?>
	
	



    </div>

 

	
	

</div>
			</div>
</div>

<br /><br /><br />