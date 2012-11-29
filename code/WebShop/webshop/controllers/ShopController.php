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
     * 过滤器
     * @return array
     */
    public function filters()
    {
        return array(
            'ajaxOnly + ajaxGetDistrict',
        );
    }

	/**
	 * 添加店辅
	 */
	public function actionAdd()
	{
        $shopInfo = $this->getRequestParam('Shop');
        if( !empty($shopInfo )){
            if(ServiceFactory::getShopService()->addShop($shopInfo)){
                $this->redirect('addSuccess');
            }
        }
		$categoryArray = ServiceFactory::getCategoryService()->getAll();
		$firstDistrictArray = ServiceFactory::getDistrictSerice()->getByLevel(District::DISTRICT_FIRST_LEVEL);
		$this->render('add', array(
			'categoryArray' => $categoryArray,
			'fisrtDistrictArray' => $firstDistrictArray
		));
	}

    /**
     * 添加店辅成功
     */
    public function actionAddSuccess()
    {
        $this->render('addSuccess');
    }

	/**
	 * ajax获取地区信息
	 */
	public function actionAjaxGetDistrict()
	{
		$upLevelId = $this->getRequestParam('upId');
		$childrenDistrictArray = ServiceFactory::getDistrictSerice()->getChildren($upLevelId);
        $responseArray = array();
        if(empty($childrenDistrictArray)){
            $responseArray['error'] = 1;
        }else{
            $responseArray['error'] = 0;
            $responseArray['district'] = array();
            foreach($childrenDistrictArray as $district){
                $responseArray['district'][] = array('id'=>$district['id'],'name'=>$district['name']);
            }
        }
        echo json_encode($responseArray);
	}
}
