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
	<?php
		if(!$users){
			echo '还没有用户';
		}
		else{
			echo '<table class="sp-grid-import">';
			echo '<tr><td>最后访问</td><td>姓名</td><td>电话</td><td>身份证</td><td>所属小区</td></tr>';
			foreach($users as $user){
				echo '<tr>';
				echo '<td>' . substr($user->updatetime,0,10) . '</td>';
				echo '<td>' . (empty($user->name) ? 'n/a' : $user->name) . '</td>';
				echo '<td>' . $user->mobile . '</td>';
				echo '<td>' . (empty($user->identification) ? 'n/a' : $user->identification) . '</td>';
				echo '<td>' . (empty($user->communityid) ? 'n/a' : Community::findOne($user->communityid)->name) . '</td>';
				echo '</tr>';
			}
			echo '</table>';
			echo LinkPager::widget(['pagination' => $pagination,]);
		}
		?>
	</div>
</div>
