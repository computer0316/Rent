<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\helpers\Url;
	use yii\widgets\LinkPager;
	use yii\captcha\Captcha;

	// 客户信息窗体

?>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/userlogin.css" />
<br /><br /><br /><br />
	<div class="form1">
		<div class="form">
			<div> <h1></h1></div>

<?php
	$form = ActiveForm::begin(['id' => 'clientform']);
?>
	<?= $form->field($user, 'mobile')->textInput() ?>

	<?= $form->field($user, 'identification')->textInput() ?>

	<?= $form->field($user, 'password')->passwordInput() ?>

	<?= $form->field($user, 'password1')->passwordInput() ?>

	<?= $form->field($user, 'verifyCode')->widget(Captcha::className()) ?>

<div class="form-group button-group">

	<?= Html::submitButton('提交', ['class' => 'submit']) ?>

	<?= Html::resetButton('重置', ['class' => 'submit']) ?>

</div>

<?php
	ActiveForm::end();
if(Yii::$app->session->hasFlash('message')){
echo "<script>alert('" . Yii::$app->session->getFlash('message') . "')</script>";
}
?>

</div></div>
