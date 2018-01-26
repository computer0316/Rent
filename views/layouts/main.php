<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\User;
use yii\helpers\VarDumper;

//AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/site.css" rel="stylesheet">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '廊坊市住房保障和房产管理局 - 公众住房房屋信息交换中心',	//Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $userid = Yii::$app->session->get('userid');
    $items[] = ['label' => '首页', 'url' => ['/site/index']];
    //$items[] = ['label' => '列表', 'url' => ['/site/list']];

	if(isset($userid)){
		$user = User::findOne(Yii::$app->session->get('userid'));
		$display = '';
		if($user){
			if(isset($user->name)){
				$display = $user->name;
			}
			else{
				$display = $user->mobile;
			}
		}
		$items[] = ['label' => $display, 'url' => ['/user/edit']];
		$items[] = ['label' => '退出', 'url' => ['/user/logout']];
	}
	else{
		$items[] = ['label' => '登录', 'url' => ['/user/login']];
	}

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $items,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <div class="left">
			<ul>
				<li><a href="?r=site/list">交换信息列表</a></li>
				<li><a href="?r=user/edit">更新个人信息</a></li>
				<li><a href="?r=user/exchange">添加交换信息</a></li>
			</ul>
        </div>
        <div class="right">
        	<?= $content ?>
        </div>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; 廊坊市住房保障和房产管理局 <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>

<?php
	$this->endPage();
	if(Yii::$app->session->hasFlash('message')){
		echo "<script>alert('" . Yii::$app->session->getFlash('message') . "')</script>";
	}
?>
