<?php
/**
 * @author yaoxianjin
 *
 * Date: 2012-10-29
 * Time: 下午3:49
 * 
 * 手机端API基础控制器
 */
class ApiBaseController extends BaseController 
{
	
	/**
	 *  过滤器
	 * 
	 * @return array
	 */
	public function filters()
	{
		return array('setHtmlCharset', 'checkKey');
	}
	
	/**
	 * 统一设置html编码为utf8
	 */
	public function filterSetHtmlCharset($filterChain) 
	{
		header( 'Content-Type:text/html;charset=utf-8' );
		$filterChain->run();
	}
	
	/**
	 * 操作合法性校验
	 */
	public function filterCheckKey($filterChain) 
	{
		$checkTime = $this->getRequestParam('checktime');
		if( $checkTime === null ){
			$this->returnErrorCode(ApiCode::API_MISSING_PARAM_CHECKTIME);
		}
		$apikey = $this->getRequestParam('apikey');
		if( $apikey != md5( $checkTime . Constant::API_CHECK_KEY) ) {
			$this->returnErrorCode(ApiCode::API_KEY_VALIDATE_ERROR);
		}	
		$filterChain->run();
	}
	
	/**
	 * 返回ErrorCode中定义的常量错误码
	 *
	 * @param int $errorCode 
	 */
	public function returnErrorCode($errorCode) 
	{
		$result = array ("returncode" => $errorCode );
		$this->renderResponse( $result );
	}
	
	/**
	 * 返回成功响应
	 *
	 * @param mixed $responseData 
	 */
	public function returnSuccessResponse($responseData = null) 
	{
		$result = array ("returncode" => ApiCode::API_OPERATE_SUCCESS);
		if ($responseData !== null) {
			$result ['response'] = $responseData;
		}
		$this->renderResponse( $result );
	}
	
	/**
	 * 输出响应结果
	 */
	private function renderResponse($result) 
	{
		$result = json_encode( $result );
		echo $result;
		Yii::app()->end();
	}
	
}