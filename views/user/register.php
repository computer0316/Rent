<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\helpers\Url;
	use yii\widgets\LinkPager;
	use yii\captcha\Captcha;

	// 客户信息窗体

?>

	<div class="form1">
		<div class="form">
<?php
	$form = ActiveForm::begin(['id' => 'clientform']);
?>
	<?= $form->field($registerForm, 'mobile')->textInput() ?>

	<?= $form->field($registerForm, 'identification')->textInput() ?>

	<?= $form->field($registerForm, 'password')->passwordInput() ?>

	<?= $form->field($registerForm, 'password1')->passwordInput() ?>

	<?= $form->field($registerForm, 'verifyCode')->widget(Captcha::className(), ['imageOptions' => ['class' => "captcha"]]) ?>

<div class="form-group button-group">

	<?= Html::submitButton('提交', ['class' => 'submit']) ?>

	<?= Html::resetButton('重置', ['class' => 'submit']) ?>

</div>

<?php
	ActiveForm::end();
?>

</div></div>
