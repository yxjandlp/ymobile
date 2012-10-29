<?php
/**
 * 错误代码类
 * 
 * @author yaoxianjin
 * 
 */
class ErrorCode {
	
	/**
	 * 不支持创建实例
	 */
	private function __construct(){}
	
	/**
	 * apikey校验错误
	 */
	const API_KEY_VALIDATE_ERROR = 1000;
	
	/**
	 * 缺少checktime参数
	 */
	const API_MISSING_PARAM_CHECKTIME = 1001;
	
}