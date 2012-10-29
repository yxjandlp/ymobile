<?php
/**
 * 基础控制器类
 * 
 * @author yaoxianjin
 */
class BaseController extends CController
{	
	/**
	 * 设置页面标题
	 *
	 * @param string $title
	 */
	public function setPageTitle($title)
	{
		parent::setPageTitle(CHtml::encode(Yii::app()->name) . ' - ' .$title);
	}
	
	/**
	 * 获得请求参数
	 *
	 * @param $paramName
	 * @param $defaultValue
	 * @return string
	 */
	public function getRequestParam($paramName, $defaultValue=null)
	{
		return Yii::app()->getRequest()->getParam($paramName, $defaultValue);;
	}
	
	/**
	 * 获取跳转返回url
	 *
	 * @return string 
	 */
	public function getReturnUrl()
	{
		$currentUrl = Yii::app()->request->getUrl();
		$returnUrl = preg_replace( '/(\w+)(\?go_url=.*)/' , '${1}' , $currentUrl );
	
		return urlencode($returnUrl);
	}
	
	/**
	 * 获取登录用户的ID
	 * 
	 * @return int ID
	 */
	public function getUserId()
	{
		return Yii::app()->user->getId();
	}
	
	/**
	 * 获取用户的昵称
	 * 
	 * @return string
	 */
	public function getNickname()
	{
		return Yii::app()->user->getName();
	}
}