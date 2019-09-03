<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$accept->scenario = 'accept';
?>
<?php $form = ActiveForm::begin(); ?>

<h5>Please be noted that you are requested to review the above manuscript.<br />
Do click accept button to accept the review request or reject button to withdraw.</h5>

<?=$form->field($accept, 'accept_at')->hiddenInput(['value' => time()])->label(false)?>

<?=Html::a('ACCEPT', ['review/review-accept', 'id' => $accept->id],
    ['class' => 'btn btn-primary', 'name' => 'wfaction', 'value' => 'accept', 'data' => [
                'confirm' => 'Are you sure to accept this review request?'
            ],
    ])?>
	 
<?=Html::a('REJECT', ['review/review-reject', 'id' => $accept->id], 
    ['class' => 'btn btn-danger', 'name' => 'wfaction', 'value' => 'reject', 'data' => [
                'confirm' => 'Are you sure to reject the review request?'
            ],
    ])?>



    </div>

    <?php ActiveForm::end(); ?>

	


<br /><br /><br />