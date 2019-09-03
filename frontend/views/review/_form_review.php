<?php

use yii\helpers\Html;
use backend\modules\jeb\models\ReviewForm;
use yii\widgets\ActiveForm;
use common\models\Upload;


$review->file_controller = 'review';

?>
<?php $form = ActiveForm::begin(); ?>
	<div class="row">
<div class="col-md-10">

<h5>Click to rate the manuscript, close to one (1) taken to mean that you strongly disagree with the statement, and close to five (5) taken to mean that you strongly agree with the statement. If a factor is not applicable, then choose "NA". You may add comments to justify your answer or modify the measure.</h5>
	<br />

<table class="table table-striped table-hover">
<thead>
<tr>
	<th>#</th>
	<th>Review Items</th>
	<th>1 = Strongly Disagree
	<br />5 = Strongly Agree
	<br />NA = Not Applicable
	</th>
</tr>
</thead>
<tbody>
	
	<?php 
	
	$i =1;
	foreach(ReviewForm::find()->all() as $f){
		$list= [
    1 => '<br />1', 
    2 => '<br />2',
	3 => '<br />3', 
	4 => '<br />4', 
	5 => '<br />5', 
	9 => '<br />NA', 
];
		echo '<tr>
		<td>'.$i.'</td>
		<td>'.$f->form_quest.'</td>
		<td>'. $form->field($review, 'q_'.$i)->radioList($list, ['encode' => false, 'separator' => ' &nbsp; &nbsp; ']) ->label(false).'</td>
	</tr>';
	$i++;
	}
	
	?>
</tbody>
</table>


<?= $form->field($review, 'review_note')->textarea(['rows' => '6']) ?>



<h5>Recommended disposition of the manuscript: check one.</h5>

<?php 
$options = ReviewForm::reviewOptions();
unset($options[0]);
echo $form->field($review, 'review_option')->radioList($options, ['encode' => false, 'separator' => '<br />']) ->label(false) ?>

<h5>Upload Reviewed Manuscript if any.</h5>

<?=Upload::fileInput($review, 'reviewed')?>
	<br /><br />

</div>
</div>
	
	



	
	
<?=Html::submitButton('<i class="fa fa-save"></i> Save Review', 
    ['class' => 'btn btn-default', 'name' => 'wfaction', 'value' => 'save'
    ])?> 
<?=Html::submitButton('Submit Review <i class="fa fa-send"></i>', 
    ['class' => 'btn btn-primary', 'name' => 'wfaction', 'value' => 'submit', 'data' => [
                'confirm' => 'Are you sure to submit this review?'
            ],
    ])?>



    </div>

    <?php ActiveForm::end(); ?>

	


<br /><br /><br />