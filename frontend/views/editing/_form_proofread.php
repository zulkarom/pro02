<?php

use yii\helpers\Html;
use yii\helpers\Url;

use yii\widgets\ActiveForm;
use common\models\Upload;


$model->file_controller = 'editing';
?>

<?php $form = ActiveForm::begin(); ?>
<div class="row">
<div class="col-md-10">






<?= $form->field($model, 'proofread_note')->textarea(['rows' => '6']) ?>



<h5>Upload Proofread File.</h5>

<?=Upload::fileInput($model, 'proofread')?>
	<br /><br />

</div>
</div>
	
	



	
	

<?=Html::submitButton('Submit Proofread <i class="fa fa-send"></i>', 
    ['class' => 'btn btn-primary', 'name' => 'wfaction', 'value' => 'btn-reviewed', 'data' => [
                'confirm' => 'Are you sure to submit this proofread?'
            ],
    ])?>





    <?php ActiveForm::end(); ?>

