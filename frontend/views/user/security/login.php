<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use dektrium\user\widgets\Connect;
use dektrium\user\models\LoginForm;
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use backend\modules\jeb\models\Journal;

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
$journal = Journal::findOne(['status' => 20]);
/**
 * @var yii\web\View $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module $module
 */

$this->title = 'JEB - LOGIN PAGE';
$this->params['breadcrumbs'][] = $this->title;



$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];


?>

<?= $this->render('/_alert', ['module' => Yii::$app->getModule('user')]) ?>

			
				<div class="block-content">

		<div class="container">
	
			<br /><div style="padding-top:0px">
					<div class="row">
					<div class="col-md-3">
					
					
					<div class="form-group">
<img src="<?=$directoryAsset?>/img/cover-page.jpg" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);" />
			</div>
			
			<div><h4>Current Issue</h4>
			
<p><?=$journal->journalName?><br /><?=$journal->journal_name?></p>
</div>
					
					
					</div>
						<div class="col-md-4">
						<h2 class="section_title">LOGIN PAGE </h2>
														<div class="section">
										
														<p>Please <a href="../user/login">log in</a> to submit a manuscript, or <a href="../user/register">register</a> if you have not an account with the JEB journal.</p>
														<br />
														
														
							<?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => false,
                    'validateOnBlur' => false,
                    'validateOnType' => false,
                    'validateOnChange' => false,
                ]) ?>							

                <?php if ($module->debug): ?>
                    <?= $form->field($model, 'login', [
                        'inputOptions' => [
                            'autofocus' => 'autofocus',
                            'class' => 'form-control',
                            'tabindex' => '1']])->dropDownList(LoginForm::loginList());
                    ?>

                <?php else: ?>
				

<?php 
$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='fa fa-envelope form-control-feedback'></span>"
];
?>

               <?=$form->field($model, 'login')
						->label('EMAIL')
            ->textInput()
                    ;
                    ?>
					
					</div>
							<div class="section">

                <?php endif ?>

                <?php if ($module->debug): ?>
                    <div class="alert alert-warning">
                        <?= Yii::t('user', 'Password is not necessary because the module is in DEBUG mode.'); ?>
                    </div>
                <?php else: ?>
				
                    <?= $form->field(
                        $model,
                        'password')
                        ->passwordInput()
                         ->label('PASSWORD')
                           
                         ?>
                <?php endif ?>

                <?php /// $form->field($model, 'rememberMe')->checkbox(['tabindex' => '3']) ?>
				
				
				 <?= Html::submitButton(
                    Yii::t('user', 'LOG IN'),
                    ['class' => 'btn btn-primary']
                ) ?>
				
				</div>
				</div>
				</div>
							<!-- end section -->
							
	

                

<?php ActiveForm::end(); ?>


				<br />
         <div class="panel-footer clearfix p10 ph15">
        
        <?php if ($module->enableRegistration): ?>
            <p>
                <?= Html::a('SIGN UP / REGISTRATION', ['/user/registration/register'], ['class' => 'field-label']) ?>
            </p>
        <?php endif ?>
		
		<?php if ($module->enablePasswordRecovery): ?>
            <p>
                <?= Html::a('FORGOT PASSWORD',
                           ['/user/recovery/request'],['class' => 'field-label', 'tabindex' => '5']
                                ) ?>
            </p>
        <?php endif ?>
		
		<?php if ($module->enableConfirmation): ?>
            <p class="text-center">
                <?= Html::a('RESEND EMAIL CONFIRMATION', ['/user/registration/resend'],['class' => 'field-label text-muted mb10', 'tabindex' => '6']) ?>
            </p>
        <?php endif ?>
		
		
		
		
		
        <?= Connect::widget([
            'baseAuthUrl' => ['/user/security/auth'],
        ]) ?>
		
		</div>
		
				</div>			</div>
</div>
				
				



