<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/common/lib.js');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/common/jquery.autoMail.js');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/register.js');?>
<h2>注册</h2>
<form method="post" name="register_form" id="register_form">
    <p>email地址：</p>
    <p><input name="User[email]" autocomplete="off" id="email" maxlength="100"/><span class="error_msg" id="email_error"><?php echo $errorArray['email'];?></span></p>
    <p>昵称：</p>
    <p><input name="User[nickname]" id="nickname" maxlength="16"/><span class="error_msg" id="nickname_error"><?php echo $errorArray['nickname'];?></span></p>
    <p>密码：</p>
    <p><input type="password" name="User[password]" id="password" /><span class="error_msg" id="password_error"><?php echo $errorArray['password'];?></span></p>
    <p id="p_strength_bk"><span class="grey" id="weak">弱</span><span class="grey" id="middle">中</span><span class="grey" id="strong">强</span></p>
    <p><input type="submit" name="register" id="register" value="注册"/></p>
</form>