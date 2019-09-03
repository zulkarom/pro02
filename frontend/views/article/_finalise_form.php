<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\jeb\models\ReviewForm;
use common\models\Upload;

$model->file_controller = 'article';

$form = ActiveForm::begin(); ?>


 
<br />

<h3>Finalise Your Manuscript</h3>

<div class="box-body"> 

<?php
if($model->finalise_option == 0){
	$model->finalise_option = 1;
}

echo $form->field($model, 'finalise_option')->radioList([
    1 => 'Accept without modification', 
    2 => 'Accept with modification'
]);

$this->registerJs('
$("input[name=\'Article[finalise_option]\'][value=1]").click(function(){
	$("#con-file").slideUp();
});
$("input[name=\'Article[finalise_option]\'][value=2]").click(function(){
	$("#con-file").slideDown();
});

');



if($model->finalise_option == 2){
	$hide_file = '';
}else{
	$hide_file = 'style="display:none"';
}

?>

<div id="con-file" <?=$hide_file?> >
<?=Upload::fileInput($model, 'finalise')?>
</div>

<?=$form->field($model, 'finalise_note')->textarea(['rows' => '6']) ?>
	

  <?=$form->field($model, 'finalise_at')->hiddenInput(['value' => time()])->label(false)?>
  






<div class="form-group">

		
	<?=Html::submitButton('Finalise Manuscript', ['class' => 'btn btn-primary', 'name' => 'wfaction', 'value' => 'recommend', 'data' => [
                'confirm' => 'Are you sure to finalise the manuscript?'
            ],
])?>

    </div>
<?php 

ActiveForm::end(); 

?>



