<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\modules\staff\models\Staff;
use common\models\User;
use common\models\UserToken;
use yii\web\ForbiddenHttpException;
use backend\modules\jeb\models\Journal;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'login-portal', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'test', 'login-portal',],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		
        return $this->render('index', [
			'journal' => Journal::findOne(['status' => 20])
		]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
			
            return $this->goBack();
        } else {
            $this->layout = "//main-login";
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionLoginPortal($u,$t)
    {
        /* if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        } */
	

        $last5 = time() - (60);
		
		$db = UserToken::find()
		->where(['user_id' => $u, 'token' => $t])
		->andWhere(['>', 'created_at', $last5])
		->one();
		
		if($db){
			$id = $db->user_id;
		   $user = User::findIdentity($id);
			if(Yii::$app->user->login($user)){
				return $this->redirect(['site/index']);
			}
		}else{
			throw new ForbiddenHttpException;
		}
    }
	

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
