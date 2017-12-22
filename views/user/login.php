<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\helpers\Url;
	use yii\widgets\LinkPager;
	// 客户信息窗体

?>
	<link rel="stylesheet" type="text/css" href="css/userlogin.css" />

	<div class="form1">
		<div class="form">
			<div> <h1>港升客户管理系统</h1></div>
<?php

	$form = ActiveForm::begin(['id' => 'clientform']);
?>

	<?= $form->field($user, 'mobile')->textInput(['class' => 'menu1']) ?>

	<?= $form->field($user, 'password')->passwordInput(['class' => 'menu2']) ?>

<div class="form-group button-group">

	<?= Html::submitButton('提交', ['class' => 'submit']) ?>

	<?= Html::resetButton('重置', ['class' => 'submit']) ?>

</div>
	</div></div>
<?php
	ActiveForm::end();
if(Yii::$app->session->hasFlash('message')){
echo "<script>alert('" . Yii::$app->session->getFlash('message') . "')</script>";
}

