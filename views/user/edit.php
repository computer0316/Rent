<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\helpers\Url;
	use yii\widgets\LinkPager;
	use app\models\Community;

	// 客户信息窗体
	$this->params['breadcrumbs'][] = '添加信息';
	$this->title = $this->params['breadcrumbs'][0] . ' - 廊坊公租房调换系统';

	$form = ActiveForm::begin(['id' => 'clientform']);
?>

	<?= $form->field($user, 'name')->textInput() ?>

	<?= $form->field($user, 'identification')->textInput() ?>

	<?= $form->field($user, 'communityid')->dropDownList(
		Community::find()->select(['name', 'id'])->indexBy('id')->column(), ['prompt' => '所属小区', 'value' => $user->communityid]
	) ?>

	<?= $form->field($user, 'address')->textInput(['placeholder' => '如：12-2-1202']) ?>

	<?= Html::submitButton('提交', ['class' => 'submit']) ?>

<?php
	ActiveForm::end();
?>
