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
		$categoryArray = ServiceFactory::getCategoryService()->getAll();
		$firstDistrictArray = ServiceFactory::getDistrictSerice()->getByLevel(District::DISTRICT_FIRST_LEVEL);
		$this->render('add', array(
			'categoryArray' => $categoryArray,
			'fisrtDistrictArray' => $firstDistrictArray
		));
	}
	
	/**
	 * ajax获取地区信息
	 */
	public function actionAjaxGetDistrict()
	{
		$upLevelId = $this->getRequestParam('upId');
		$childrenDistrictArray = ServiceFactory::getDistrictSerice()->getChildren($upLevelId);
	}
}
