<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use common\models\Upload;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = 'Upload Manuscript File';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Upload Manuscript File';
$model->file_controller = 'submission';
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
	<?php $form = ActiveForm::begin(['id' => 'form-submission']); ?>
	<div class="form-group"><?=Upload::fileInput($model, 'submission')?></div>
	
	
	
	<?=$form->field($model, 'pre_evaluate_at')->hiddenInput(['value' => time()])->label(false)?>
	
	<br /><br />
	
	<p>Please check the items below before submitting:</p>
	<br />
	
	<div class="form-group">
	<label><input type="checkbox" class="verifychk" id="check1" /> This submission has not been previously published, nor is it before another journal for consideration<br /> (or an explanation has been provided in Comments to the Editor).</label>
	</div>
	
	<div class="form-group">
	<label><input type="checkbox" class="verifychk" id="check2" /> This submission file is in Microsoft Word file format.</label>
	</div>
	
	<div class="form-group">
	<label><input type="checkbox" class="verifychk" id="check3" /> The text adheres to the stylistic and bibliographic requirements for JEB.</label>
	</div>
	
	<div class="form-group">
	<label><input type="checkbox" class="verifychk" id="check4" /> That in submitting this article, the Author(s) is aware of the Journal’s policy on plagiarism.</label>
	</div>
	
	<div class="form-group">
	<label><input type="checkbox" class="verifychk" id="check5" /> That the copyright for all portions of this article will be transferred to the journal upon acceptance.</label>
	</div>
	

<br /><br /><br />

    
    
    
    <input type="hidden" id="wfaction" name="wfaction" value="btn-draft" />
    

	
	<div class="form-group">
		<?=Html::a('<i class="fa fa-arrow-left"></i> BACK', ['update', 'id' => $model->id], 
		['class' => 'btn btn-warning']) ?>
		<?= Html::submitButton('<i class="fa fa-save"></i> SAVE AS DRAFT', ['class' => 'btn btn-default']) ?>
        <?= Html::button('SUBMIT <i class="fa fa-send"></i>', ['class' => 'btn btn-primary', 'name' => 'wfaction' ,'value' => 'btn-submit', 'id' => 'btn-submit'
]) ?>
    </div>

    <?php ActiveForm::end(); ?>
	
	
	
	
	
    

</div>			</div>
</div>



<?php 

$this->registerJs('


$("#btn-submit").click(function(){
	
	if($(".verifychk:checked").length == $(".verifychk").length){
		$("#wfaction").val("btn-submit");
		$("#form-submission").submit();
	}else{
		alert("Please check all the checkboxes before submitting!");
		
	}
	
});

');

?>