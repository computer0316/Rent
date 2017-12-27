<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\helpers\Url;
	use yii\widgets\LinkPager;
	use yii\captcha\Captcha;
	use yii\helpers\VarDumper;

	// 客户信息窗体

?>
<html>
	<head>
		<meta charset="utf-8">
		<style>
			div{
				width:30px;
				height:30px;
				float:left;
				border:1px solid;
				border-radius:30px;
				margin-left:5px;
				text-align:center;
			}
			span{
				color:white;
				font-size:19px;
			}
			.red{
				border:red;
				background:red;
			}
			.blue{
				border:blue;
				background:blue;
			}
		</style>
	</head>
	<body>

<?php
		foreach($reds as $red){
			echo '<div class="red"><span>' . $red . "</span></div>&nbsp;\n";
		}
		echo '<div class="blue"><span>' . $blue . '</span></div>';
?>
</body>
</html>