<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use frontend\models\Stats;

frontend\models\MainAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

	
	
</head>
<body>
<?php $this->beginBody() ?>


<div class="super_container">

	<!-- Header -->

	<header class="header">
			
		<!-- Top Bar -->
		<div class="top_bar">
			<div class="top_bar_container">
				<div class="container">
					<div class="row">
						<div class="col">
							<div class="top_bar_content d-flex flex-row align-items-center justify-content-start">
								<div class="top_bar_phone"><span class="top_bar_title">Journal of Entrepreneurship and Business (e-ISSN:2289-8298)</div>
								<div class="top_bar_right ml-auto">
								
								

									<!-- Language -->
									<div class="top_bar_lang">
										<span class="top_bar_title">
										
			<?php 
			if(Yii::$app->user->isGuest){
				echo '<i class="fa fa-user"></i> <a href="' . Url::to(["/user/login"]) . '">LOGIN</a> OR <a href="'.Url::to(["/user/register"]) . '">REGISTER</a></span>';
			}else{
				
				echo Html::a('<i class="fa fa-user"></i> ' . Yii::$app->user->identity->fullname, ['user-setting/change-password'], ['data-method' => 'POST']);
				
				echo Html::a(' | LOGOUT', ['site/logout'], ['data-method' => 'POST']);
			}
			
			
			?>
										
										
										
										
									</div>

								
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>				
		</div>

		<!-- Header Content -->
		
		<img src="<?=$directoryAsset?>/img/top-banner.png" width="100%" />
	
		
		<div class="header_container">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="header_content d-flex flex-row align-items-center justify-content-start">
							<div class="logo_container mr-auto">
								<a href="<?=Url::to(['site/index'])?>">
							<div class="logo_text" style="color:#000000">J E B</div></a>
								
							</div>
				<?php 
				
				function menu($mm = false){
					$lbl_logout = 'LOG OUT';
					if(Yii::$app->user->isGuest){
						$arr = [
							'HOME' => Url::to(['/site/index']),
							'EDITORIAL COMMITTEE' => Url::to(['/page/committee/']),
							'SUBMISSION GUIDELINE' => Url::to(['/page/submission-guideline']),
							'EDITORIAL POLICY' => Url::to(['/page/editorial-policy']),
							'ETHICAL GUIDELINE' => Url::to(['/page/ethical-guideline']),
							'ARCHIVES' => Url::to(['/page/archive']),
					
						];
						if($mm){
							$arr['LOGIN'] = Url::to(['/user/login']);
							$arr['REGISTER'] = Url::to(['/user/register']);
						}
					}else{
						$submission = Stats::mySubmission();
						if($submission > 0){
							$color_sub = 'danger';
							$bdg_subm = '<span class="badge badge-danger">'.$submission.'</span>';
						}else{
							$bdg_subm = '';
						}
						$reviews = Stats::myReview();
						if($reviews > 0){
							$bdg_review = '<span class="badge badge-danger">'.$reviews.'</span>';
						}else{
							$bdg_review = '';
						}
						
						$arr = [
							'HOME' => Url::to(['/site/index']),
							'SUBMISSION '.$bdg_subm => Url::to(['/submission/index']),
							'REVIEW '.$bdg_review => Url::to(['review/index']),
							'EDITING' => Url::to(['editing/index']),
							'PROFILE' => Url::to(['user-setting/change-password']),
							$lbl_logout => Url::to(['site/logout']),
						
							
						];
					}
					
					$str = '';$cl = '';
					if($mm){
						$cl = ' class="menu_mm"';
					}
					foreach($arr as $label=>$url){
						$str .= '<li'.$cl.'>';
						if($label == $lbl_logout){
							$str .= Html::a($label, $url, ['data-method' => 'POST']);
						}else{
							$str .= '<a href="'.$url.'">'.$label.'</a>';
						}
						
						$str .= '</li>';
					}
					
					return $str;
				}
				
				?>
							<nav class="main_nav_contaner">
								<ul class="main_nav">
									<?=menu()?>
								</ul>
							</nav>
							<div class="header_content_right ml-auto text-right">
							

								<div class="hamburger menu_mm">
									<i class="fa fa-bars menu_mm" aria-hidden="true"></i>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>

	</header>

	<!-- Menu -->

	<div class="menu d-flex flex-column align-items-end justify-content-start text-right menu_mm trans_400">
		<div class="menu_close_container"><div class="menu_close"><div></div><div></div></div></div>

		<nav class="menu_nav">
			<ul class="menu_mm">
				<?=menu(true)?>
			</ul>
		</nav>

	</div>
	
	
	<?= Alert::widget() ?>
	
	<?=$content?>


	<!-- Footer -->
<br /><br /><br />
	<footer class="footer">
		<div class="footer_body">
			<div class="container">
				<div style="color:#cccccc; font-size:11px" align="center">
				
				Faculty of Entrepreneurship and Business, Universiti Malaysia Kelantan <br />
Pengkalan Chepa, 16100 Kota Bharu, Kelantan, Malaysia<br />
Tel: +609 771 7251 Fax: +609 771 7252<br />
Copyright <?=date('Y')?> Universiti Malaysia Kelantan
				
				</div>
			</div>
		</div>
		<div class="copyright">
			<div class="container">
				<div class="row">
					<div class="col">
						<div class="copyright_content d-flex flex-md-row flex-column align-items-md-center align-items-start justify-content-start">
							<div class="cr">
							
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Made by Skyhint Design | Template by <a style="color:#a5a5a5" href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->


</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
</div>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
