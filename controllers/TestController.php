<?php

namespace app\controllers;

class TestController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');

    }

}

class Test{
	public $a='a';
	public $b='b';
	public function test{
		echo 'c';
	}
}
