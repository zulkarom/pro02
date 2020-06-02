<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use backend\modules\jeb\models\Journal;
use yii\widgets\ActiveForm;


$this->title= 'JEB :: JOURNAL OF ENTREPRENEURSHIP AND BUSINESS';

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
?>
	<!-- Home -->

	<div>
		<div></div>
		<div class="form-group">
		<img src="<?=$directoryAsset?>/img/background-simple.jpg" width="100%" />
		</div>
		
		
		<?php $form = ActiveForm::begin([
        'action' => ['search/index'],
        'method' => 'get',
    ]); ?>
		<div class="row">
		<div class="col-md-2"></div>
			<div class="col-md-6">
			<div class="form-group">
			
			 <?= $form->field($model, 'search_article')->textInput(['class' => 'form-control', 'style' => 'height:45px', 'placeholder' => 'Search articles in title, abstract or keywords...'])->label(false); ?>
			 
			</div>
			</div>
			<div class="col-md-2">
			<div class="form-group">
			
			
		
			
			 <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary', 'style' => 'height:45px']) ?>
			
			
			</div>
			</div>
		</div>
		 <?php ActiveForm::end(); ?>

	</div>
	

	<!-- Language -->

	

	<!-- Courses -->

	<div class="courses">
		<div class="container">
		
			<div class="row">
			
			<div class="col-lg-6">
			<h3>AIM OF JOURNAL</h3>
			
			<p>The Journal of Entrepreneurship and Business (eISSN : 2289-8298) or JEB is a double-blind, peer-reviewed and open-access journal, published in June and December annually. JEB addresses the fundamental issues of entrepreneurship and business and publishes original quantitative or qualitative articles on all aspects of entrepreneurship and business in local and international contexts. The primary audiences for this journal are scholars, academicians, policy makers and practitioners whose interest is in entrepreneurship and business discourses, practices and activities. </p></div>
				
				<div class="col-lg-6">
				<h3>SCOPE</h3>
				<p>JEB welcomes and publishes research in the field of :
<ul>
<li>Retailing and commerce;</li>
<li>Logistics and distributive trade;</li>
<li>Tourism and hospitality;</li>
<li>Finance and accounting;</li>
<li>Business sustainability;</li>
<li>Entrepreneurship & economic growth;</li>
<li>Entrepreneurship development programme & policy;</li>
<li>Social entrepreneurship; </li>
<li>and Human capital and entrepreneurship.</li>
</ul>

</p>

	<p>This journal is abstracted and indexed by EBSCOhost, Ulrichsweb™,  MCC, MyCite and Google Scholar .</p>				
				</div>
			
			</div>
<br />
	
<div class="row">
<div class="col-md-9">
<h4>INDEXING</h4>

<a href="https://www.asean-cites.org/" target="_blank"><img src="<?=$directoryAsset?>/img/aci-logo-v4.png" width="180" /></a> 

<a href="https://www.ebsco.com/" target="_blank"><img src="<?=$directoryAsset?>/img/ebsco.gif" width="130" /></a> 

<a href="http://ulrichsweb.serialssolutions.com" target="_blank"><img src="<?=$directoryAsset?>/img/ulrichs.gif" width="180" /></a> 

<a href="http://www.udledge.com/" target="_blank"><img src="<?=$directoryAsset?>/img/udl.png" width="150" /></a> 

<br />
<a href="https://scholar.google.com.my/" target="_blank"><img src="<?=$directoryAsset?>/img/google_scholar.jpg" /></a> 
<a href="http://mycc.my/" target="_blank"><img src="<?=$directoryAsset?>/img/mcc.jpg" width="180" /></a> 

<a href="http://www.mycite.my/" target="_blank"><img src="<?=$directoryAsset?>/img/mycite.gif" /></a> 

<a href="https://theadl.com/journal.php?search=Journal%20of%20Entrepreneurship%20and%20Business" target="_blank"><img src="<?=$directoryAsset?>/img/adl.png" /></a> 


</div>
<div class="col-md-3">
<h4>MEMBERSHIP</h4>
<a href="https://www.crossref.org/" target="_blank"><img src="<?=$directoryAsset?>/img/crossref.jpg" width="180" /></a>
<br /><br />
<h4>PLAGIARISM CHECK</h4>
<a href="https://www.turnitin.com/" target="_blank"><img src="<?=$directoryAsset?>/img/turnitin.jpg" /></a>

</div>
</div>
			
<br /><br />	

<div class="row">
<div class="col-md-4"></div>
<div class="col-md-4">

<div align="center"><a href="https://creativecommons.org/licenses/" target="_blank">
<img src="<?=$directoryAsset?>/img/88x31.png" /></a>
</div>
This work is licensed under a <a href="https://creativecommons.org/licenses/by/3.0/" target="_blank">Creative Commons Attribution 3.0 Unported License</a>
</div>

</div>
			
			
		</div>
	</div>
	
	<div class="register" style="padding-bottom:10px;padding-top:50px">
		<div class="container">
		
		<div class="row">
				<div class="col">
					<h2 class="section_title text-center">CURRENT ISSUE</h2>
				</div>
		</div>
		
		<br />
			<?php 
			
			$journal = Journal::findOne(['status' => 20]);
			
			if($journal){
				echo $this->render('_list_articles', [
						'journal' => $journal,
				]);
			}else{
				echo 'In progress';
			}
			?>
		
		</div>
			

		</div>
	</div>
	
