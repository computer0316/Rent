<?php

namespace app\controllers;

use Yii;
use yii\base\ErrorException;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

use yii\Roc\IO;
use yii\Roc\Session;
use yii\Roc\SMS;

use app\models\Tools;
use app\models\LoginForm;
use app\models\User;
use app\models\Exchange;




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

    public function actionEdit(){
    	$exchange = Exchange::find()->where(true)->one();
    	return $this->render('edit', ['exchange' => $exchange]);
    }

	// 用户登录
	public function actionLogin(){
		$this->layout	= 'login';
		$loginForm		= new LoginForm();
		$post = Yii::$app->request->post();
		if($loginForm->load($post)){
			$smsCode = rand(100000,999999);
			Yii::$app->session->set('smscode', $smsCode);
			//SMS::send($user->mobile, "【房管局公共住房】验证码：" . $smsCode);
			return $this->render('sms', ['loginForm' 	=> $loginForm]);
		}
		return $this->render('login', ['loginForm' => $loginForm]);
	}

	public function actionGetSms(){
		$this->layout = 'login';
		$session = Yii::$app->session;

		$post = Yii::$app->request->post();
		$loginForm = new loginForm();
		if($loginForm->load($post)){
			if($loginForm->smsCode == Yii::$app->session->get('smscode')){
				if(!User::login($loginForm)){
					Yii::$app->session->setFlash('message',"登录失败。请于管理员联系。");
				}
				return $this->redirect(Url::toRoute('site/index'));
			}
			else {
			 	Yii::$app->session->setFlash('message',"验证码错误");
			 	return $this->render('sms', ['loginForm' => $loginForm]);
			}
		}
		else{
			Yii::$app->session->setFlash('message',"user读取失败，请联系管理员。");
		}

	}

	public function actionLogout(){
		Yii::$app->session->remove('userid');
		$this->redirect(Url::toRoute("/site/index"));
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
					$user = new user(['scenario' => 'register']);
					$user->mobile =  $registerForm->mobile;
					$user->identification = $registerForm->identification;
					$smsCode = rand(100000,999999);
					Yii::$app->session->set('smscode', $smsCode);
					//SMS::send($user->mobile, "【房管局公共住房】验证码：" . $smsCode);
					return $this->render('sms', ['user'	=> $user]);
				}
			}
			else{	// 如身份证不存在，则提示后返回
				Yii::$app->session->setFlash('message', '数据库中不存在此身份证！');
			}
			//$registerForm = new RegisterForm();
		}
		return $this->render('register', ['registerForm' => $registerForm]);
	}

	/*
		随机显示一个双色球
	*/
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

}
