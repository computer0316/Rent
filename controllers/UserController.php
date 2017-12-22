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
use app\models\User;
use yii\base\Exception;



class UserController extends Controller
{
	public $enableCsrfValidation = false;

	public function actionLogin(){
		$this->layout = false;
		$user = new User();
		$post = Yii::$app->request->post();
		if($user->load($post)){
			if($user->login()){
				$this->redirect(Url::toRoute("/site/index"));
			}
			else{
				Yii::$app->session->setFlash('message', '用户名或者密码错。');
			}
		}
		return $this->render('login', ['user' => $user]);
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
