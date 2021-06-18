<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

use common\models\LoginForm;
use common\models\User;
use common\models\UserToken;
use common\models\Upload;

use backend\modules\jeb\models\Journal;
use backend\modules\jeb\models\Article;

use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\SearchArticle;
use frontend\models\Page;





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
                        'actions' => ['signup', 'index', 'login', 'staff-login', 'download', 'error'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index', 'staff-login', 'error'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
		
		if(Yii::$app->user->isGuest){
			
			$journal = Journal::findOne(['status' => 20]);
			
			$model = new SearchArticle();
			return $this->render('index', [
				'model' => $model,
				'journal' => $journal
				]);
		}else{
			return $this->render('member', [
			]);
		}
        
    }
	
	/* public function actionDownload($article){
		
        $model = $this->findArticle($article);
		
		Upload::download($model, 'cameraready', 'article');
	}*/
	
	public function actionDownload($volume, $issue, $publish_number){
		
		$all = $volume.$issue;
		
		$len = strlen((string)$all);
		
		if($len == 4){
			$first = $all[0];
			$second = $all[1];
			$third = $all[2];
			$forth = $all[3];
			
			if($first == '0'){
				$volume = $second;
			}else{
				$volume = $first.$second;
			}
			
			if($third == '0'){
				$issue = $forth;
			}else{
				$issue = $third.$forth;
			}
		}else if($len == 5){
			$first = $all[0];
			$second = $all[1];
			$third = $all[2];
			$forth = $all[3];
			$fifth = $all[4];
			
			$volume = $first.$second.$third;
			
			if($forth == '0'){
				$issue = $fifth;
			}else{
				$issue = $forth.$fifth;
			}
		}
		
        $model = $this->searchArticle($volume, $issue, $publish_number);
		
		
		
		Upload::download($model, 'cameraready', 'article');
	} 
	
	/**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findArticle($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	/**
     * Finds the Article model based on its attributes.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function searchArticle($volume, $issue, $publish_number)
    {
        if (($model = Article::find()
        ->innerJoin('jeb_journal', 'jeb_journal.id = jeb_article.journal_id')
         ->where(['jeb_journal.volume' => $volume, 'jeb_journal.issue' => $issue, 'jeb_article.publish_number' => $publish_number])
        ->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function findPageIdentity()
    {
		$id = Yii::$app->user->identity->id;
		$customer = Customer::findOne(['user_id' => $id]);
        if (($model = Page::findOne(['customer_id' => $customer->id ])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->goBack();
			return $this->goHome();
        } else {
			$this->layout = "//main-login";
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['/user/login']);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
				Yii::$app->session->addFlash('success', "Registration Successful");
               return $this->redirect(['site/login']);
            }
        }
		
		$this->layout = "//main-login";

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
	
	public function actionStaffLogin($id, $token, $redirect = '', $action = '', $article = 0)
    {
		if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
        }
		
		$last5 = time() - (60);
		
		$db = UserToken::find()
		->where(['user_id' => $id, 'token' => $token])
		->andWhere('created_at > ' . $last5)
		->one();
		
		if($db){
		   $user = User::findIdentity($id);
			if(Yii::$app->user->login($user)){
				if($redirect){
					return $this->redirect([$redirect . '/' . $action, 'id' => $article]);
				}else{
					return $this->goHome();
				}
			}
		}else{
			//echo 'failed';
			throw new ForbiddenHttpException;
		}
		
       
		
    }
}
