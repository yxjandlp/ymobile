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
		<div id="header">
			<div id="h_content">
				<div id="logo"><a href="<?php echo Yii::app()->homeUrl;?>"><h2><?php echo Yii::app()->name;?></h2></a></div>
				<div id="h_op">
	                <ul>
	                    <?php if( Yii::app()->user->isGuest ):?>
	                    <li><a href="<?php echo Yii::app()->homeUrl.'login?back_to='.$this->getReturnUrl();?>">登录</a></li>
	                    <li><a href="<?php echo Yii::app()->createUrl('register/');?>">注册</a></li>
	                    <?php endif;?>
	                    <?php if( ! Yii::app()->user->isGuest):?>
	                    <li><a href="javascript:void(0);"><?php echo $this->getNickname();?></a></li>
                        <li><a href="<?php echo Yii::app()->createUrl('accounts/changePwd');?>">修改密码</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl('logout/');?>">退出</a></li>
	                    <?php endif;?>
	                </ul>
				</div>
			</div>
		</div>
		<div id="content">
			<?php echo $content; ?>	
		</div>
		<div id="footer"></div>
	</div>
</body>
</html>
