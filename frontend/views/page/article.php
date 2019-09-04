<?php 

use yii\helpers\Url;


$this->title= $model->title . ' - Journal of Entrepreneurship and Business';
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
?>



<div class="block-content">

		<div class="container">
			
			<br />
			<div class="row">
			<div class="col-lg-1"></div>
			<div class="col-lg-8">
			<p>
			<b>Journal of Entrepreneurship and Business</b><br />
			
			<div class="row">
<div class="col-md-6"><i style="font-size:10pt"><a href="<?=Url::to(['page/journal', 'id' => $model->journal_id])?>">Back to <?=$model->journal->journalName?></a></i></div>

<div class="col-md-6" align="right"><i style="font-size:10pt">Page <?=$model->page_from?> - <?=$model->page_to?></i>
</div>

</div>
			
			
			</p>
			<hr />
			
			<div class="row">
				<div class="col">
					<h2 class="section_title" style="margin-bottom:25px;"><?=$model->title?></h2>
				</div>

			</div>
			
			<p><?=$model->authorString(', ')?></p>
			
			<p><i style="font-size:10pt">DOI: https://doi.org/<?=trim($model->doi_ref)?></i></p>
			
			
			
			<hr />
			<h4 style="margin-bottom:25px;">Abstract</h4>
			
			<p style="text-align:justify">
			<?=$model->abstract?>
			</p>
			
			<h4 style="margin-bottom:25px;margin-top:20px;">Keywords</h4>
			
			<p>
			<?=$model->keyword?>
			</p>
			
			<h4 style="margin-bottom:25px;margin-top:20px;">Cite As</h4>
			
			<p>
			<?=$model->citation?>
			</p>
			
			<h4 style="margin-bottom:25px;margin-top:20px;">Export Citation</h4>
			
			<p>
			<div class="form-group"><a href="<?=Url::to(['page/bibtext', 'id' => $model->id])?>" class="btn btn-outline-primary" target="_blank"><i class="fa fa-download"></i> BibTex</a></div>
			</p>
			
			<h4 style="margin-bottom:25px;margin-top:20px;">Full Text</h4>
			
			<p>
			<div class="form-group"><a href="<?=Url::to($model->linkArticle())?>" class="btn btn-outline-danger" target="_blank"><i class="fa fa-download"></i> PDF</a></div> 
			</p>
			
			<?php if($model->reference){?>
			
			<h4 style="margin-bottom:25px;margin-top:20px;">References</h4>
			
			<style>
			
			div.reference ol li {
				margin-bottom: 20px;
				font-size: 16px;
				list-style-type: none;
			}
			
			</style>
			
			
			
			<?php echo '<div class="reference">' . $model->reference . '</div>';
			}
			?> 
			
			
			
			
			
			
			</div>
			
		
				
				<br />
				
				
				
			
			</div>
			

		</div>
	</div>
	
<br /><br /><br />