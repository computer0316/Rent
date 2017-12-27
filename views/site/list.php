<?php

/* @var $this yii\web\View */

	use yii\helpers\Html;
	use yii\widgets\LinkPager;
	use app\models\User;
	use app\models\Community;

$this->title = '列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
	.sp-grid-import{border-collapse: collapse;width:100%; border:1px solid #E1E6EB; border-left:none;}
.sp-grid-import thead th{line-height:20px;padding:8px 12px; border-bottom:1px solid #E1E6EB; border-left:1px solid #E1E6EB; white-space: nowrap; text-align:center; font-weight:normal !important;letter-spacing:1px;}
.sp-grid-import tbody td{text-align: center;line-height:20px;padding:8px 10px;font-size:13px;border-bottom:1px solid #E1E6EB; border-left:1px solid #E1E6EB;}
</style>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <div>
		<table class="sp-grid-import">
			<tr><td>时间</td><td>现居小区</td><td>目标小区</td></tr>
	<?
		foreach($registers as $register){
			echo '<tr>';
			echo '<td>' . $register->updatetime . '</td>';
			echo '<td>' . User::find()->where(['id' => $register->userid])->one()->name . '</td>';
			echo '<td>' . Community::findOne($register->target_communityid)->name . '</td>';

			echo '</tr>';
		}
		echo LinkPager::widget([
			'pagination' => $pagination,
		]);
	?>
		</table>
	</div>
</div>
