<?php

namespace app\controllers;

use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Register;
use app\models\Community;
use app\models\IO;
use app\models\User;
use yii\helpers\Url;

class SiteController extends Controller
{

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

    public function actionAddlist(){
    	die("虚拟100个提交的数据");
    	for($i=0;$i<100;$i++){
    		$register = new Register();
    		$register->userid 		= rand(92,121);
			$register->target_communityid = rand(1,5);
			$register->updatetime = date("Y-m-d H:i:s");
			$register->save();
			echo $register->target_communityid . '<br />';
    	}
    }

	public function actionList(){
		$query	= Register::find();
		$count	= $query->count();
		$pagination = new Pagination(['totalCount' => $count]);
		$pagination->pageSize = 18;
		$registers	= $query->offset($pagination->offset)
					->limit($pagination->limit)
					->all();
		return $this->render('list', [
					'registers'		=> $registers,
					'pagination'	=> $pagination,
					]);
	}

	public function actionShow($id = 0){
		if($id>0){
			$article = Article::findOne($id);
			return $this->render('show', ['article' => $article]);
		}
		else{
			$error	= "文章没找到";
		}

	}
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		return $this->redirect(Url::toRoute('site/list'));
    }

	public function actionAdd(){
		$register	= new Register();
		$post		= Yii::$app->request->post();
		if($register->load($post)){
			$register->userid		= 1;
			$register->communityid	= 1;
			$register->address		= '10-2-1102';
			$register->updatetime = date("Y-m-d H:i:s");
			//VarDumper::Dump($register);
			if($register->save()){
				Yii::$app->session->setFlash('message', '信息登记成功');
				return $this->render('add', ['register' => $register]);
			}
			else{
				VarDumper::Dump($register->errors);
			}
		}
		else{
			return $this->render('add', ['register' => $register]);
		}
	}

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
