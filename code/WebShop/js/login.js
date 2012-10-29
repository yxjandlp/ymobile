function clearError(){
	$('#email_error').html('');
	$('#password_error').html('');
}
$(document).ready(function(){
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
	$('#login').click(function(){
		clearError();
		if($.trim($('#email').val()) == ''){
			$('#email_error').html('请输入登录邮箱');
			return false;
		}
		if($('#password').val() == ''){
			$('#password_error').html('请输入密码');
			return false;
		}
		$('#login_form').submit();
	});
});