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
			<span id="logintitle">房屋交换系统用户登录</span>
<?php

	$form = ActiveForm::begin(['action' => Url::toRoute('user/get-sms'), 'id' => 'clientform']);
?>

		<?= $form->field($loginForm, 'mobile')->hiddenInput()->label(false) ?>

	<div class="form-group">

		<?= $form->field($loginForm, 'smsCode')->textInput() ?>

	</div>
		<?= Yii::$app->session->get('smscode') ?>


<div class="form-group button-group">

	<?= Html::submitButton('提交', ['class' => 'submit']) ?>
	<span>还没有注册？点<a href="?r=user/register">这里</a>注册</span>
</div>

<?php
	ActiveForm::end();
?>
</div></div>
