<?php

namespace app\controllers;

use Yii;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Tools;
use app\models\LoginForm;
use app\models\RegisterForm;
use app\models\User;
use yii\base\ErrorException;



class UserController extends Controller
{
	public $enableCsrfValidation = true;

	public function beforeAction($action)
	{
		if (parent::beforeAction($action)) {
			if ($this->enableCsrfValidation) {
				Yii::$app->getRequest()->getCsrfToken(true);
			}
			return true;
		}

		return false;
	}
	    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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
                'height' => 40,
                'width' => 80,
                'minLength' => 4,
                'maxLength' => 4
            ],
        ];
    }

	public function actionDoubleColorBall(){
		$this->layout = false;
		$temp = rand(1,33);
		$reds[] = rand(1,33);
		for($i=0;$i<5;$i++){
			while(in_array($temp, $reds)){
				$temp = rand(1,33);
			}
			$reds[] = $temp;
		}
		sort($reds);
		$blue = rand(1,16);
		return $this->render('ball', [
			'reds' => $reds,
			'blue' => $blue,
		]);
	}

	// 用户注册
	public function actionRegister(){
		$this->layout = 'login';
		$registerForm = new RegisterForm();
		$post = Yii::$app->request->post();
			if($registerForm->load($post)){
				$user = User::find()->where(['identification' => $registerForm->identification])->one();
				if($user){
					if($user->mobile == $registerForm->mobile){
						Yii::$app->session->setFlash('message', "此手机号已注册，请直接登录。");
					}
					else{
						return $this->render('captcha', ['user' => $user]);
					}
				}
				else{
					Yii::$app->session->setFlash('message', '数据库中不存在此身份证！');
				}
				//$registerForm = new RegisterForm();
			}
			return $this->render('register', ['registerForm' => $registerForm]);
	}

	// 用户登录
	public function actionLogin(){
		$this->layout	= 'login';
		$loginForm		= new LoginForm();
		$post = Yii::$app->request->post();
		if($loginForm->load($post)){
			if(User::login($loginForm)){
				Yii::$app->session->setFlash('message', '用户登录成功。');
				$this->redirect(Url::toRoute("/site/index"));
				Yii::$app->end();
			}
			else{
				Yii::$app->session->setFlash('message', '用户名或者密码错。');
			}
		}
		return $this->render('login', ['loginForm' => $loginForm]);
	}

	// 修改密码
	public function actionChpass(){
		try{
			$userLoad = new User(['scenario' => 'changepassword']);
			if($userLoad->load(Yii::$app->request->post())){
				$user = User::findOne(Yii::$app->session->get('userid'));
				$user->changePassword($userLoad);
				Yii::$app->session->setFlash('message', '密码修改成功');
			}
		}
		catch(Exception $e){
			Yii::$app->session->setFlash('message', $e->getMessage());
		}
		return $this->render('chpass', [
			'user'	=> $userLoad,
			]);
	}

	public function actionLogout(){
		User::logout();
		$this->redirect(Url::toRoute("/site/index"));
	}

	public function actionMd5(){
		echo '*' . md5('rocisaboy') . '*';

	}
}
