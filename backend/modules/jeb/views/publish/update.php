<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use common\models\Todo;
use yii\bootstrap\Modal;
use backend\modules\jeb\models\ReviewForm;
use common\models\Upload;
use yii\widgets\ActiveForm;
use backend\modules\jeb\models\Journal;
use yii\helpers\ArrayHelper;
use backend\modules\jeb\models\ArticleScope;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model common\models\Application */

$this->title = 'Update';
$this->params['breadcrumbs'][] = ['label' => 'Editing', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

if(Todo::can('jeb-managing-editor')){

$form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

<div class="box">
<div class="box-header"></div>
<div class="box-body">

<?= $form->field($model, 'title')->textarea(['rows' => 2]) ?>

 
  <?= $form->field($model, 'abstract')->textarea(['rows' => 6]) ?>
  
 <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.author-item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-author',
        'deleteButton' => '.remove-author',
        'model' => $authors[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'firstname',
            'lastname',
			'email'
        ],
    ]); ?>
    
    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th width="35%">Fist Name</th>
                <th width="35%">Last Name</th>
				<th width="35%">Email</th>
                <th class="text-center" style="width: 90px;">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($authors as $indexAu => $author): ?>
            <tr class="author-item">
            
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $author->isNewRecord) {
                            echo Html::activeHiddenInput($author, "[{$indexAu}]id");
                        }
                    ?>
                    <?= $form->field($author, "[{$indexAu}]firstname")->label(false) ?>
                </td>
                
                <td class="vcenter">
          
                    
                     <?=$form->field($author, "[{$indexAu}]lastname")->label(false);

                    ?>

                </td>
				
				<td class="vcenter">
          
                    
                     <?=$form->field($author, "[{$indexAu}]email")->label(false);

                    ?>

                </td>
                
                


                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-author btn btn-default btn-sm"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
                <td colspan="3">
                <button type="button" class="add-author btn btn-default btn-sm"><span class="fa fa-plus"></span> Add Author</button>
                
                </td>
                <td>
                
                
                </td>
            </tr>
        </tfoot>
        
    </table>
    
    
    
    <?php DynamicFormWidget::end(); ?>
  
 <?= $form->field($model, 'keyword')->textarea(['rows' => 2]) ?>
    <?=$form->field($model, 'reference')->textarea(['rows' => 6]) ?>
	

	


<?php 
$model->file_controller = 'publish';
echo Upload::fileInput($model, 'cameraready')?>




</div>
</div>

  <div class="form-group">
		<?= Html::submitButton('<i class="fa fa-save"></i> UPDATE ARTICLE', ['class' => 'btn btn-primary']) ?>

    </div>


<?php 

ActiveForm::end(); 
}
?>

