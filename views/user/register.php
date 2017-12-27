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
			<span id="logintitle">房屋交换系统用户注册</span>

			<?php
				$form = ActiveForm::begin(['id' => 'clientform']);
			?>
				<?= $form->field($registerForm, 'mobile')->textInput(['autofocus' => true]) ?>

				<?= $form->field($registerForm, 'identification')->textInput() ?>

				<?= $form->field($registerForm, 'password')->passwordInput() ?>

				<?= $form->field($registerForm, 'password1')->passwordInput() ?>

				<?= $form->field($registerForm, 'verifyCode')->widget(Captcha::className(), ['imageOptions' => ['class' => "captcha"]]) ?>

				<div class="form-group button-group">

					<?= Html::submitButton('注&nbsp;册', ['class' => 'submit']) ?>
					<span>已经注册？点<a href="?r=user/login">这里</a>登录</span>

				</div>

				<?php
					ActiveForm::end();
				?>
		</div>
	</div>
