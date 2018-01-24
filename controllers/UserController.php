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
use yii\Roc\IO;
use yii\Roc\Session;
use yii\Roc\SMS;



class UserController extends Controller
{
	public $enableCsrfValidation = true;

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
				'fixedVerifyCode' => substr(rand(1000,9999), 0),
                'height' => 50,
                'width' => 100,
                'maxLength' => 4,
                'minLength' => 4,

            ],
        ];
    }

    public function actionTest(){
    	echo rand(1000, 9999);
    	echo Yii::$app->session->get('userid');
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

	/*
		用于已经有身份证的用户注册
	*/

	public function actionRegisterOld(){
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
					$loginForm = new loginForm(['scenario' => 'register']);
					$loginForm->mobile =  $registerForm->mobile;
					$loginForm->identification = $registerForm->identification;
					$smsCode = rand(100000,999999);
					Yii::$app->session->set('smscode', $smsCode);
					//SMS::send($loginForm->mobile, "【房管局公共住房】验证码：" . $smsCode);
					return $this->render('sms', ['loginForm'	=> $loginForm]);
				}
			}
			else{	// 如身份证不存在，则提示后返回
				Yii::$app->session->setFlash('message', '数据库中不存在此身份证！');
			}
			//$registerForm = new RegisterForm();
		}
		return $this->render('register', ['registerForm' => $registerForm]);
	}

	public function actionRegisterok(){
		$id = User::register($loginForm);
				if($id){
					$session->set('userid', $id);
					return $this->redirect(Url::toRoute('site/index'));
				}
				else{
					Yii::$app->session->setFlash('message',"注册失败，请联系管理员。");
				}
	}


	public function actionGetSms(){
		$this->layout = 'login';
		$session = Yii::$app->session;

		$post = Yii::$app->request->post();
		$loginForm = new loginForm();
		if($loginForm->load($post)){
			if($loginForm->smsCode == Yii::$app->session->get('smscode')){
				if($loginForm->method == 'login'){
					User::login($loginForm);
				}
				else{
					User::register($loginForm);
				}
				return $this->redirect(Url::toRoute('site/index'));
			}
			else {
			 	Yii::$app->session->setFlash('message',"验证码错误");
			 	return $this->render('sms', ['loginForm' => $loginForm]);
			}
		}
		else{
			Yii::$app->session->setFlash('message',"loginForm读取失败，请联系管理员。");
		}

	}

	// 用户登录
	public function actionLogin(){
		$this->layout	= 'login';
		$loginForm		= new LoginForm();
		$post = Yii::$app->request->post();
		if($loginForm->load($post)){
			if(User::find()->where(['mobile' => $loginForm->mobile])->one()){
				$loginForm->identification	= '111111111111111111';
				$loginForm->method			= 'login';
				$smsCode = rand(100000,999999);
				Yii::$app->session->set('smscode', $smsCode);
				//SMS::send($loginForm->mobile, "【房管局公共住房】验证码：" . $smsCode);
				return $this->render('sms', ['loginForm' 	=> $loginForm]);
			}
			else{
				Yii::$app->session->setFlash('message',"手机号还没有注册，请先注册。");
				return $this->redirect(Url::toRoute('user/register'));
			}
		}
		return $this->render('login', ['loginForm' => $loginForm]);
	}

	public function actionLogout(){
		Yii::$app->session->remove('userid');
		$this->redirect(Url::toRoute("/site/index"));
	}
}
