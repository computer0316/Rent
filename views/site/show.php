<?php

/* @var $this yii\web\View */

	use yii\helpers\Html;
	use yii\widgets\LinkPager;

$this->title = '文章';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

<?
		echo $article->updatetime . '&nbsp;';
		echo '<font size="+3">' . $article->title . '</font><br />';
		echo $article->content . '<br />';

?>
</div>
