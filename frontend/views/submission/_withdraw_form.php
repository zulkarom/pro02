<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>

<?php $form = ActiveForm::begin(['action' => ['submission/withdraw', 'id' => $model->id]]); ?>

<?=$form->field($model, 'updated_at')->hiddenInput(['value' => 1])->label(false)?>
<div class="form-group">
* You can request to withdraw your manuscript before final decision on reviewing process. <br /><br />

<?= $form->field($model, 'withdraw_note')->textarea(['rows' => '6']) ?>

<?=Html::submitButton('WITHDRAW REQUEST', 
    ['class' => 'btn btn-danger btn-sm', 'name' => 'wfaction', 'value' => 'btn-verify', 'data' => [
                'confirm' => 'Are you sure to withdraw this manuscript?'
            ],
    ])?>

    </div>

    <?php ActiveForm::end(); ?>