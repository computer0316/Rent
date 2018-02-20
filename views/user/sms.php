<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\helpers\Url;
	use yii\widgets\LinkPager;
	use yii\captcha\Captcha;
	// 客户信息窗体

?>
<SCRIPT type="text/javascript">
            var maxtime = 6; //一个小时，按秒计算，自己调整!
            function CountDown() {
            	if(maxtime >= 0){
                	document.all["timer"].innerHTML = maxtime;
                	--maxtime;
                }
            }
            timer = setInterval("CountDown()", 1000);
</SCRIPT>

	<div class="form1">
		<div class="form">
			<div id="logintitle">房屋交换系统短信验证</div>
<?php

	$form = ActiveForm::begin(['action' => Url::toRoute('user/get-sms'), 'id' => 'clientform']);
?>

		<?= $form->field($loginForm, 'mobile')->hiddenInput()->label(false) ?>

	<div class="form-group">

		<?= $form->field($loginForm, 'smsCode')->textInput() ?>
		<div id="timer"></div>

	</div>



<div class="form-group button-group">

	<?= Html::submitButton('提交', ['class' => 'submit']) ?>

</div>

<?php
	ActiveForm::end();
?>
</div></div>
