<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/common/jquery.autoMail.js');?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/login.js');?>
<h2>登录</h2>
<?php $form=$this->beginWidget('CActiveForm');?>
<?php echo $form->error($model, 'email', array('class'=>'e_msg'));?>
<?php echo $form->label($model, '登录邮箱：');?>
<p><?php echo $form->textField($model, 'email', array('id'=>'email'));?><span class="e_msg" id="email_error"></span></p>
<p><?php echo $form->label($model,'密码:');?></p>
<p><?php echo $form->passwordField($model, 'password', array('id'=>'password'));?><span class="e_msg" id="password_error"></span></p>
<p>
<?php echo $form->checkBox($model, 'rememberMe');?>
<?php echo $form->label($model, '两周内自动登录');?>
</p>
<?php echo CHtml::submitButton('登录', array('id' => 'login'));?>
<?php $this->endWidget();?>
