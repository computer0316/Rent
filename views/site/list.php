<?php

/* @var $this yii\web\View */

	use yii\helpers\Html;
	use yii\widgets\LinkPager;

$this->title = '列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

<?
	foreach($articles as $article){
		echo $article->updatetime . '&nbsp;';
		echo '<font size="+1"><a href="index.php?r=site/show&id=' . $article->id . '">' . $article->title . '</a></font><br />';

		//echo $article->content . '<br />';

		echo '<hr />';
	}
	echo LinkPager::widget([
		'pagination' => $pagination,
	]);
?>
</div>
