<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use common\models\Upload;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = 'Upload Submission File';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Upload File';
$model->file_controller = 'article';
?>
<div class="block-content">

		<div class="container">
			<div class="row">
				<div class="col">
					<h2 class="section_title text-center"><?= Html::encode($this->title) ?></h2>
				</div>

			</div>
			<br /><div class="article-update">
<style>
table.detail-view th {
    width:15%;
}
</style>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
			'title:ntext',
			[
				'label' => 'Authors',
				'format' => 'html',
				'value' => function($model){
					return $model->authors;
				}
			],
			'abstract:ntext',
			[
				'label' => 'Scope',
				'format' => 'html',
				'value' => function($model){
					return $model->scope->scope_name;
				}
			]

			

        ],
    ]) ?>
	<br />
	<div class="form-group"><?=Upload::fileInput($model, 'submission')?></div>
	
	
	<?php $form = ActiveForm::begin(); ?>
	<?=$form->field($model, 'pre_evaluate_at')->hiddenInput(['value' => time()])->label(false)?>
	
	<div class="form-group">
		<?= Html::submitButton('<i class="fa fa-save"></i> SAVE AS DRAFT', ['class' => 'btn btn-default', 'name' => 'wfaction' , 'value' => 'btn-draft']) ?>
        <?= Html::submitButton('SUBMIT <i class="fa fa-send"></i>', ['class' => 'btn btn-primary', 'name' => 'wfaction' , 'value' => 'btn-submit', 'data' => [
                'confirm' => 'Are you sure to submit this manuscript?'
            ],
]) ?>
    </div>

    <?php ActiveForm::end(); ?>
	
	
	
	
	
    

</div>			</div>
</div>
