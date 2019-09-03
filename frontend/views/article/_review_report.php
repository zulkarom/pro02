<?php

use yii\bootstrap\Modal;
use backend\modules\jeb\models\ReviewForm;
use common\models\Upload;

?>
<br />

<h3>Reviewers Report</h3>

<table class="table table-bordered table-striped">
        <thead>
            <tr>
				<th width="40%">Reviewer(s)</th>
                <th>Review Note</th>
				 <th>File</th>
                <th class="text-center" style="width: 90px;">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php
		if($reviewers){
			$x =1;
			foreach($reviewers as $review){
				echo '<tr>
				<td>Reviewer '.$x.'</td>
			<td>' . nl2br($review->review_note) . '</td>
				<td>' . Upload::showFile($review, 'reviewed', 'review') . '</td>
				<td>';
				
				?>
				
					<!-- Button to Open the Modal -->
<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
  <i class="fa fa-eye"></i> VIEW
</button>

<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Modal Heading</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
<div class="col-md-12">
<table class="table table-striped table-hover">
<thead>
<tr>
	<th>#</th>
	<th>Review Items</th>
	<th>1 - 5 / NA 
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




</div>
</div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
				
				<?php


				
				echo '</td>
				</tr>';
			$x++;	
			}
		}
		
		?>
		
		<tr>
		<td>Managing Editor</td>
		<td><?=nl2br($model->response_note)?></td>
		<td></td>
		<td></td>
		
		</tr>
        </tbody>
        

        
    </table>


	
	
