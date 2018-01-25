<?php

/* @var $this yii\web\View */

	use yii\helpers\Html;
	use yii\widgets\LinkPager;
	use app\models\User;
	use app\models\Community;

$this->title = '列表';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-about">
    <div>
		<table class="sp-grid-import">
			<tr><td>时间</td><td>姓名</td><td>电话</td><td>房屋面积</td><td>现居小区</td><td>目标小区</td></tr>
	<?
		foreach($Exchanges as $Exchange){
			echo '<tr>';
			echo '<td>' . $Exchange->updatetime . '</td>';
			echo '<td>' . User::findOne($Exchange->userid)->name . '</td>';
			echo '<td>' . User::findOne($Exchange->userid)->mobile . '</td>';
			echo '<td>' . User::findOne($Exchange->userid)->area . '</td>';
			echo '<td>' . Community::find()->where(['id' => User::findOne($Exchange->userid)->communityid])->one()->name . '</td>';
			echo '<td>' . Community::findOne($Exchange->target_communityid)->name . '</td>';

			echo '</tr>';
		}
	?>
		</table>
		<?
		echo LinkPager::widget([
			'pagination' => $pagination,
		]);
		?>
	</div>
</div>
