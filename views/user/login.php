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
			<div id="logintitle">房屋交换系统用户登录</div>
<?php

	$form = ActiveForm::begin(['id' => 'clientform']);

?>

	<?= $form->field($loginForm, 'mobile')->textInput(['autofocus' => true, 'class' => 'menu1']) ?>

	<?= $form->field($loginForm, 'verifyCode')->widget(Captcha::className(), ['imageOptions' => ['class' => "captcha"]]) ?>

<div class="form-group button-group">

	<?= Html::submitButton('提交', ['class' => 'submit']) ?>

</div>

<?php
	ActiveForm::end();
?>
</div></div>
