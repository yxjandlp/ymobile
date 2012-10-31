<?php
/**
 * 店辅控制器
 * 
 * @author yaoxianjin
 * Date: 2012-10-31
 * Time: 16:19
 */
class ShopController extends BaseController
{
	/**
	 * 添加店辅
	 */
	public function actionAdd()
	{
		$this->render('add', array());
	}
}
