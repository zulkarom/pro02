<?php

use yii\helpers\Html;



/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = 'Submit Manuscript';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="block-content">

		<div class="container">
			<div class="row">
				<div class="col">
					<h2 class="section_title text-center">SUBMIT MANUSCRIPT</h2>
				</div>

			</div>
			<br />
			
			
			
			<div class="article-create">


    <?= $this->render('_submission_form', [
        'model' => $model,
		'authors' => $authors
    ]) ?>

</div>
			
			
			
		</div>
</div>

