<?php
/**
 * 错误代码类
 * 
 * @author yaoxianjin
 * 
 */
class ApiCode 
{
	/**
	 * 不支持创建实例
	 */
	private function __construct(){}
	
	/**
	 * 操作成功
	 */
	const API_OPERATE_SUCCESS = 0;
	
	/**
	 ************************************
	 *  通用错误 1000-1999
	 ************************************
	 */
	
	/**
	 * apikey校验错误
	 */
	const COMMON_KEY_VALIDATE_ERROR = 1000;
	
	/**
	 * 缺少checktime参数
	 */
	const COMMON_MISSING_PARAM_CHECKTIME = 1001;
	
	/**
	 ************************************
	 *  注册、登录时错误 2000-2999
	 ************************************
	 */
	
	/**
	 * email不能为空
	 */
	const REGISTER_EMAIL_CANNOT_LEAVE_EMPTY = 2000;
	
	/**
	 * email格式错误
	 */
	const REGISTER_EMAIL_ILLEGAL_FORMAT = 2001;
	
	/**
	 * email已被注册
	 */
	const REGISTER_EMAIL_ALREADY_BEEN_USED = 2002;
	
	/**
	 * 昵称不能为空
	 */
	const REGISTER_NICKNAME_CANNOT_LEAVE_EMPTY = 2003;
	
	/**
	 * 昵称过长，最长为16位
	 */
	CONST REGISTER_NICKNAME_LENGTH_TOO_LONG = 2004;
	
	/**
	 * 昵称格式错误，需为昵1－16位的中英文、数字或_
	 */
	const REGISTER_NICKNAME_ILLEGAL_FORMAT = 2005;
	
	/**
	 * 昵称已被使用
	 */
	const REGISTER_NICKNAME_ALREADY_BEEN_USED = 2006;
	
	/**
	 * 密码不能为空
	 */
	const REGISTER_PASSWORD_CANNOT_LEAVE_EMPTY = 2007;
	
	/**
	 * 密码最少为6位
	 */
	const REGISTER_PASSWORD_LENGTH_TOO_SHORT = 2008;
	
	/**
	 * 登录邮箱或密码错误
	 */
	const LOGIN_WRONG_EMAIL_OR_PASSWORD = 2009;
	
	
}