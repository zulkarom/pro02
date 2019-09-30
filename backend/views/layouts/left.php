<?php 
use common\models\Todo;
use yii\helpers\Url;
use backend\modules\jeb\models\Menu as JebMenu;

?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                &nbsp;
            </div>
            <div class="pull-left info">
                <p>
				<?php 
		  $str = Yii::$app->user->identity->fullname;
		  if (strlen($str) > 10)
		$str = substr($str, 0, 17) . '...';
		  echo $str;
		  ?>
				
				</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
		
		<?php 
		
		
		$my = [];
		$focus = [];
		$admin_focus = [];
		
		switch(Yii::$app->controller->module->id){
			case 'jeb':
			$focus = JebMenu::committee();
			$admin_focus = JebMenu::adminJeb();
			break;

			
			default:
			$admin_focus = JebMenu::adminJeb();
			$focus = JebMenu::committee();
		}
		
		
		
		?>

        <?=common\models\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Main Menu', 'options' => ['class' => 'header']],
					//['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['/site']],
					//$modules,
					$focus,
					$admin_focus,
					
					
					
					['label' => 'Log Out', 'icon' => 'arrow-left', 'url' => ['/site/logout'], 'template' => '<a href="{url}" data-method="post">{icon} {label}</a>']


                ],
            ]
        ) ?>

    </section>

</aside>
