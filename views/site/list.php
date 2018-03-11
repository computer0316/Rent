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
		if(!$exchanges){
			echo '还没有房屋交换信息';
		}
		else{
			echo '<table class="sp-grid-import">';
			echo '<tr><td>时间</td><td>姓名</td><td>电话</td><td>现居小区</td><td>目标小区</td></tr>';
			foreach($exchanges as $exchange){
				echo '<tr>';
				echo '<td>' . substr($exchange->updatetime,0,10) . '</td>';
				echo '<td>' . GetUserSurname($exchange->userid) . '</td>';
				echo '<td>' . User::findOne($exchange->userid)->mobile . '</td>';
				echo '<td>' . Community::find()->where(['id' => User::findOne($exchange->userid)->communityid])->one()->name . '</td>';
				echo '<td>' . Community::findOne($exchange->target_communityid)->name . '</td>';

				echo '</tr>';
			}
			echo '</table>';
			echo LinkPager::widget(['pagination' => $pagination,]);
		}
		?>
	</div>
</div>

<?php
function GetUserSurname($id){
	$user		= User::findOne($id);
	$sexNumber	= substr($user->identification, 16, 1);
	switch($sexNumber){
		case "0":
		case "2":
		case "4":
		case "6":
		case "8":
			return substr($user->name, 0, 3) . "女士";
			break;
		case "1":
		case "3":
		case "5":
		case "7":
		case "9":
			return substr($user->name, 0, 3) . "先生";
			break;
	}
}
