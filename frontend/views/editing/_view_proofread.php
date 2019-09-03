<?php

use yii\helpers\Html;
use yii\helpers\Url;

use common\models\Upload;

?>


<div class="row">
<div class="col-md-10">


<div class="form-group"><strong>Proofread Note: </strong><?=$model->proofread_note;?></div>



<h5>Upload Proofread File.</h5>

<?=Upload::showFile($model, 'proofread', 'editing')?>
	<br /><br />

</div>
</div>
	
	


