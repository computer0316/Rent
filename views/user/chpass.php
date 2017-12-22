<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\helpers\Url;
	use yii\widgets\LinkPager;
	// 客户信息窗体

	$form = ActiveForm::begin(['id' => 'clientform']);

	echo $form->field($user, 'password')->passwordInput();

	echo $form->field($user, 'password1')->passwordInput();

	echo $form->field($user, 'password2')->passwordInput();

	echo Html::submitButton('提交', ['class' => 'submit']);

	ActiveForm::end();

