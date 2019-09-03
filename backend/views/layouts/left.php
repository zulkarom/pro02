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
                <img src="<?= Url::to(['/staff/staff/image']) ?>" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>
				<?php 
		  $str = Yii::$app->user->identity->staff->staff_name;
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
		
		
		
		
		
		$admin_jeb = [
                        'label' => 'JEB Admin',
						'visible' => Todo::can('jeb-administrator'),
                        'icon' => 'list-ul',
                        'url' => '#',
                        'items' => [
						
				//['label' => 'Admin Stats', 'icon' => 'dashboard', 'url' => ['/jeb'],],
				
				
				
				['label' => 'User Management', 'icon' => 'user', 'url' => ['/jeb/user']],
				
				['label' => 'General Setting', 'icon' => 'cog', 'url' => ['/jeb/setting']],
				
				['label' => 'Email Template', 'icon' => 'envelope', 'url' => ['/jeb/email-template']],


                 ]
                    ]
		
		;
		
		$erpd = [
                        'label' => 'e-RPD Menus',
                        'icon' => 'list-ul',
                        'url' => '#',
                        'items' => [
						
				['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['/erpd'],],
				
				['label' => 'Research', 'icon' => 'book', 'url' => ['/erpd/research'],],
				
				['label' => 'Publication', 'icon' => 'send', 'url' => ['/erpd/publication'],],
				
				
				
				['label' => 'Membership', 'icon' => 'pencil', 'url' => ['/jeb/submission'],],
				
				['label' => 'Award', 'icon' => 'book', 'url' => ['/jeb/submission'],],
				
				['label' => 'Consultation', 'icon' => 'book', 'url' => ['/jeb/submission'],],
				
				['label' => 'Knowledge Transfer', 'icon' => 'book', 'url' => ['/jeb/submission'],],


                 ]
                    ]
		
		;
		
		$staff = [
                        'label' => 'Staff Menus',
                        'icon' => 'list-ul',
                        'url' => '#',
                        'items' => [
						
				['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['/jeb'],],
				
				['label' => 'Staff List', 'icon' => 'send', 'url' => ['/staff/staff'],],
				

                 ]
                    ]
		
		;
		$my = [];
		$focus = [];
		$admin_focus = [];
		
		switch(Yii::$app->controller->module->id){
			case 'jeb':
			$focus = JebMenu::committee();
			$admin_focus = $admin_jeb;
			break;
			
			case 'erpd':
			$focus = $erpd;
			break;
			
			case 'staff':
			$focus = $staff;
			break;
			
			default:
			$admin_focus = $admin_jeb;
			$focus = JebMenu::committee();
		}
		
		
		$modules = [
                        'label' => 'Modules',
                        'icon' => 'th-large',
                        'url' => '#',
                        'items' => [
                            
							['label' => 'e-RPD', 'icon' => 'file', 'url' => ['/erpd'],],
							
							['label' => 'e-SIAP', 'icon' => 'file', 'url' => ['question-cat/index'],],
							
							['label' => 'JEB', 'icon' => 'file', 'url' => ['/jeb'],],
							
							['label' => 'STAFF', 'icon' => 'database', 'url' => ['/staff'],],
							

                        ],
                    ];
		
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
					
					[
                        'label' => 'User Management',
                        'icon' => 'lock',
						'visible' => Todo::can('sysadmin'),
                        'url' => '#',
                        'items' => [
							
							['label' => 'New External User', 'icon' => 'plus', 'url' => ['/user/create'],],
						
							['label' => 'User Role', 'icon' => 'user', 'url' => ['/user/assignment'],],
							
							//['label' => 'User Signup', 'icon' => 'plus', 'url' => ['/admin/user/signup'],],
							
							
							/* ['label' => 'User Assignment', 'icon' => 'user', 'url' => ['/admin'],], */
						
                            ['label' => 'Role List', 'icon' => 'user', 'url' => ['/admin/role'],],
							
							['label' => 'Route List', 'icon' => 'user', 'url' => ['/admin/route'],],
							
	
							

                        ],
                    ],
					
					//['label' => 'Change Password', 'icon' => 'lock', 'url' => ['/user/change-password']],
					
					['label' => 'Log Out', 'icon' => 'arrow-left', 'url' => ['/site/logout'], 'template' => '<a href="{url}" data-method="post">{icon} {label}</a>']
					



					


                ],
            ]
        ) ?>

    </section>

</aside>
