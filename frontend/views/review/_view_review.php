<?php

use backend\modules\jeb\models\ReviewForm;
use common\models\Upload;


?>

	

	<div class="row">
<div class="col-md-10">

<h5>Below is the review information.</h5>
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
$quest = 'q_'.$i;
$res = $review->{$quest};
if($res == 9){
	$res = 'NA';
}
		echo '<tr>
		<td>'.$i.'</td>
		<td>'.$f->form_quest.'</td>
		<td>'. $res .'</td>
	</tr>';
	$i++;
	}
	
	?>
</tbody>
</table>

<h5>Review Note.</h5>

<?=nl2br($review->review_note) ?>
<br />
<br />


<h5>Recommended disposition of the manuscript.</h5>

<?=ReviewForm::reviewOptions()[$review->review_option] ?>
<br />
<br />

<h5>Uploaded Reviewed Manuscript.</h5>

<?=Upload::showFile($review, 'reviewed', 'review')?>

	<br /><br />

</div>
</div>
	


<br /><br /><br />