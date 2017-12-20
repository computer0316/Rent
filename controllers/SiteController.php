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
use app\models\Article;
use app\models\Category;
use app\models\ArticleCategory;

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

	public function actionList(){
		$query	= Article::find()->where(['like', 'originurl', '.html']);
		$count	= $query->count();
		$pagination = new Pagination(['totalCount' => $count]);
		$pagination->pageSize = 10;
		$articles	= $query->offset($pagination->offset)
					->limit($pagination->limit)
					->all();
		return $this->render('list', [
					'articles'		=> $articles,
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
    	echo '<meta charset="utf-8">';
    	ob_start();
    	echo str_repeat("&nbsp;", 1024) . "<br />";
    	ob_flush();
    	$article	= Article::find()->where("urlgot=0 and originurl like '%.html'")->one();
    	while($article){
    		//echo $article->originurl . "<br />";ob_flush();
    		$parts	= $this->getParts($article->originurl);
    		$this->saveCategory($parts, $article->id);
    		$article->urlgot	= 1;
    		$article->save();
    		$article	= Article::find()->where("urlgot=0 and originurl like '%.html'")->one();
    		ob_flush();
    		flush();
    	}
    }

	private function saveCategory($newCate, $id){
		foreach($newCate as $cate){
			$category = Category::find()->where(['name' => $cate])->one();
			if($category){
				$ac = new ArticleCategory();
				$ac->articleid = $id;
				$ac->categoryid= $category->id;
				$ac->save();
			}
			else{
				$category = new Category();
				$category->name = $cate;
				echo $cate . '<br />';
				$category->save();
			}
		}
	}

	private function getParts($url){
		$parts = explode('/', substr($url, 26));
		unset($parts[count($parts)-1]);
		return $parts;
	}

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
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
