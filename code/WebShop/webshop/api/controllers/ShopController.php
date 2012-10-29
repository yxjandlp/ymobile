<?php
/**
 * 测试手机端API框架 
 * 
 * @author yaoxianjin
 */
class ShopController extends ApiBaseController {
	
	/**
	 * 获取所有商家列表
	 */
	public function actionGetAll() {
		$shops = Shops::model()->findAll();
		$responseArray = array();
 		if( $shops ){
			foreach( $shops as $shop ){
				$responseArray[] = array(
						'id' => $shop['id'],
						'titlle' => $shop['title']
				);
			}
		} 
		$this->returnSuccessResponse($responseArray);
	}
	
}