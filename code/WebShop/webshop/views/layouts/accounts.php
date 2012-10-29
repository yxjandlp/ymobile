<!doctype html>
<html xmlns="http://www.w3.org/1999/html">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
    <meta name="Description" content="" />
    <meta name="Keywords" content="" />
    <?php Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/main.css');?>
    <?php Yii::app()->clientScript->registerCoreScript('jquery');?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body>
	<div id="page">
		<div id="reg">
			<?php echo $content; ?>	
		</div>
	</div>
</body>
</html>

