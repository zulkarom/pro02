<?php
namespace frontend\models;

class MainAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@frontend/views/myasset';
    public $css = [
		'styles/bootstrap4/bootstrap.min.css',
		'plugins/font-awesome-4.7.0/css/font-awesome.min.css',
		'styles/main_styles.css',
		'styles/responsive.css'
    ];
	public $js = [
		//'js/jquery-3.2.1.min.js',
		'js/popper.min.js',
		'styles/bootstrap4/bootstrap.min.js',
		'plugins/easing/easing.js',
		'js/custom.js',
		'js/gauge.min.js',
		
	];

    public $depends = [
        //'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
        //'yii\bootstrap\BootstrapPluginAsset',
    ];

}
