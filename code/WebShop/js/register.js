function clear(){
	$('#email_error').html('');
	$('#nickname_error').html('');
	$('#password_error').html('');
}
function pwdStrengthInit(){
	$('#weak').attr('class','grey');
	$('#middle').attr('class','grey');
	$('#strong').attr('class','grey');
}
function pwdWeak(){
	pwdStrengthInit();
	$('#weak').attr('class','green');
}
function pwdMiddle(){
	pwdStrengthInit();
	$('#weak').attr('class','green');
	$('#middle').attr('class','green');
}
function pwdStrong(){
	pwdStrengthInit();
	$('#weak').attr('class','green');
	$('#middle').attr('class','green');
	$('#strong').attr('class','green');
}
function emailCheck(){
	var email = $.trim($('#email').val());
	if(email == ''){
		$('#email_error').html('email不能为空');
		$('#email').focus();
		return false;
	}
	if( ! validateEmail(email)){
		$('#email_error').html('email格式错误');
		$('#email').focus();
		return false;
	}
	return true;
}
function nicknameCheck(){
	var nickname = $.trim($('#nickname').val());	
	if(nickname ==''){
		$('#nickname_error').html('昵称不能为空');
		$('#nickname').focus();
		return false;
	}
	if(nickname.length > 16){
		$('#nickname_error').html('昵称过长，最长为16位');
		$('#nickname').focus();
		return false;
	}
	var nicknamePn = /^[0-9a-zA-Z\u4e00-\u9fa5_]*$/;
	if(! nicknamePn.exec(nickname)){
		$('#nickname_error').html('昵称格式错误，需为昵1－16位的中英文、数字或_');
		$('#nickname').focus();
		return false;
	}
	return true;
}
function passwordCheck(){
	var password = $.trim($('#password').val());
	if(password == ''){
		$('#password_error').html('密码不能为空');
		$('#password').focus();
		return false;
	}
	if(password.length < 6){
		$('#password_error').html('密码不能少于6位');
		$('#password').focus();	
		return false;
	}
	return true;
}
$(document).ready(function(){
	$('#register').click(function(){
		clear();
		if(!(emailCheck() && nicknameCheck() && passwordCheck())){
			return false;
		}
	});
	$('#email').keydown(function(e){
		if(e.keyCode == 13){
			return false;
		}
	});
	 $("#email").mailAutoComplete({
	     boxClass: "out_box", 
	     listClass: "list_box",
	     focusClass: "focus_box",
	     markCalss: "mark_box", 
	     autoClass: false,
	     textHint: true, 
	     hintText: "请输入邮箱地址"
	 
	 });
	$('#email').blur(function(){
		var email = $.trim($(this).val());
		if(emailCheck()){
			$('#email_error').html('');
	        var data = "email=" + email;
	        var to_url = "accounts/ajaxIsEmailUsed";
	        $.ajax({
	            "type" : "POST",
	            "url" : to_url,
	            "data" : data,
	            "success" : function(data){
	                if( data == "1"){
	                	$('#email_error').html("邮箱已被注册");
	                }
	             }
	        });
		}
	});
	$('#nickname').blur(function(){
		var nickname = $.trim($(this).val());
		if(nicknameCheck()){
			$('#nickname_error').html('');
	        var data = "nickname=" + nickname;
	        var to_url = "accounts/ajaxIsNicknameUsed";
	        $.ajax({
	            "type":"POST",
	            "url":to_url,
	            "data":data,
	            "success":function(data){
	                if(data == "1"){
	                	$('#nickname_error').html("昵称已被使用");
	                }
	             }
	        });
		}
	});
	$('#password').blur(function(){
		if(passwordCheck()){
			$('#password_error').html('');	
		}
	});
	$('#password').keyup(function(){
		var password = $(this).val();
		var length = password.length;
		if(length >= 6){
			var strength = getPasswordStrength(password);
			console.log(strength);
			if(strength == 1){
				pwdWeak();
			}else if(strength == 2){
				pwdMiddle();
			}else if(strength > 2){
				pwdStrong();
			}
		}else if(length > 0){
			pwdWeak();
		}else{
			pwdStrengthInit();
		}
	});
});