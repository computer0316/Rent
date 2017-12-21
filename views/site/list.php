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
	foreach($registers as $register){
		echo $register->updatetime . '&nbsp;';
		echo '<font size="+1"><a href="index.php?r=site/show&id=' . $register->id . '">' . $register->target_communityid . '</a></font><br />';

		//echo $article->content . '<br />';

		echo '<hr />';
	}
	echo LinkPager::widget([
		'pagination' => $pagination,
	]);
?>
</div>
