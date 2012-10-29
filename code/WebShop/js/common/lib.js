/**********************************
 * 
 * JS公用函数
 * 
 **********************************/

/**
 * 去除两端空白
 */
function trim(value){
	 return value.replace(/^\s+|\s+$/g,"");  
}

/**
 * 验证邮箱
 */
function validateEmail(email){
	var pattern=/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/;
	return pattern.test(email);					                                              				
}

/**
 * 判断密码强度
 */
function getPasswordStrength(password){
    return 0
        // if password bigger than 5 give 1 point
        + +( password.length > 5 )
        // if password has both lower and uppercase characters give 1 point
        + +( /[a-z]/.test(password) && /[A-Z]/.test(password) )
        // if password has at least one number and at least 1 other character give 1 point
        + +( /\d/.test(password) && /\D/.test(password) )
        // if password has a combination of other characters and special characters give 1 point
        + +( /[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/.test(password) && /\w/.test(password) )
        // if password bigger than 12 give another 1 point (thanks reddit)
        + +( password.length > 12 )
}