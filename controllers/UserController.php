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
use app\models\SMSForm;
use yii\base\ErrorException;
use yii\Roc\IO;
use yii\Roc\Session;
use yii\Roc\SMS;



class UserController extends Controller
{
	public $enableCsrfValidation = true;
/*
	public function beforeAction($action)
	{
		if (parent::beforeAction($action)) {
			if ($this->enableCsrfValidation) {
				Yii::$app->getRequest()->getCsrfToken(true);
			}
			return true;
		}

		return false;
	}*/
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
				'fixedVerifyCode' => substr(md5(time()),11,4),
                'height' => 50,
                'width' => 100,
                'maxLength' => 4,
                'minLength' => 4,

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
		$this->layout = 'login';	// 采用login显示格式
		$registerForm = new RegisterForm();	// 新建一个 registerForm 模型
		$post = Yii::$app->request->post(); // post 数据提交到一个变量
		if($registerForm->load($post)){		// 从 post 数据载入到模型类实力
			// 检查身份证是否存在
			$user = User::find()->where(['identification' => $registerForm->identification])->one();
			if($user){	// 如存在，则开始注册流程
				if(User::find()->where(['mobile' => $registerForm->mobile])->one()){
					Yii::$app->session->setFlash('message', "此手机号已注册，请直接登录。");
					return $this->redirect(['user/login']);
				}
				else{
					$smsForm = new SMSForm();
					$smsForm->mobile =  $registerForm->mobile;
					$smsForm->identification = $registerForm->identification;
					$smsCode = rand(100000,999999);
					Yii::$app->session->set('smscode', $smsCode);
					SMS::send($smsForm->mobile, "【房管局公共住房】验证码：" . $smsCode);
					return $this->render('sms', ['smsForm' => $smsForm]);
				}
			}
			else{	// 如身份证不存在，则提示后返回
				Yii::$app->session->setFlash('message', '数据库中不存在此身份证！');
			}
			//$registerForm = new RegisterForm();
		}
		return $this->render('register', ['registerForm' => $registerForm]);
	}


	public function actionGetSms(){
		$this->layout = 'login';
		$session = Yii::$app->session;

		$post = Yii::$app->request->post();
		$smsForm = new SMSForm();
		if($smsForm->load($post)){
			if($smsForm->SmsCode == Yii::$app->session->get('smscode')){
				$id = User::register($smsForm);
				if($id){
					$session->set('userid', $id);
					return $this->redirect(Url::toRoute('site/index'));
				}
				else{
					Yii::$app->session->setFlash('message',"注册失败，请联系管理员。");
				}
			}
			else {
			 	Yii::$app->session->setFlash('message',"验证码错误");
			 	return $this->render('sms', ['smsForm' => $smsForm]);
			}
		}
		else{
			Yii::$app->session->setFlash('message',"smsForm读取失败，请联系管理员。");
		}

	}

	// 用户登录
	public function actionLogin(){
		$this->layout	= 'login';
		$loginForm		= new LoginForm();
		$post = Yii::$app->request->post();
		if($loginForm->load($post)){
			if(User::login($loginForm)){
				Yii::$app->session->setFlash('message', '用户登录成功。');
				return $this->redirect(Url::toRoute("/site/index"));
				//Yii::$app->end();
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
		Yii::$app->session->remove('userid');
		$this->redirect(Url::toRoute("/site/index"));
	}
}
