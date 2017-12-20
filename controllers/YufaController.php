<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\helpers\Url;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Download;
use app\models\Yufa;

class YufaController extends Controller
{
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
    	echo '<meta charset="utf-8">';
//    	$yufa = Yufa::findOne(743); //->where(['like', 'content', 'yingyuyufa.com'])->one();
//    	echo $yufa->content;die();
    	$yufa = Yufa::find()->where(['like', 'content', 'yingyuyufa.com'])->one();
    	ob_start();
    	echo "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
    	echo "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
    	echo "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
    	echo "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
    	echo "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
    	echo "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
    	echo "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
    	echo "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
    	echo "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
    	echo "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
    	echo "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
    	echo "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
    	echo "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
    	echo "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
    	echo "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
    	echo "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
    	echo "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
    	echo "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
    	echo "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
    	echo "1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890";
    	$i = 0;
    	while($yufa){
	    	echo $i++ . ' ' . $yufa->title . '<br />';
	    	ob_flush();
	    	//echo $yufa->content;
	    	$pattern = '/www\.yingyuyufa\.com/';
	    	preg_match_all($pattern, $yufa->content, $matches);
	    	//VarDumper::Dump($matches);
	    	//die();
	    	if($matches[0] && count($matches[0]>0)){
	    		foreach($matches as $match){
	    			$yufa->content = str_replace($match, '', $yufa->content);
	    		}
	    	}
			$yufa->save();
			$yufa = Yufa::find()->where(['like', 'content', 'yingyuyufa.com'])->one();
		}
    }

}
