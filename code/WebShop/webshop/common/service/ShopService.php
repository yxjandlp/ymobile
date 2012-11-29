<?php
/**
 * 店辅Service
 *
 * @author yaoxianjin
 * Date: 12-11-29
 * Time: 17:05
 */
class ShopService extends ActionService
{
    /**
     * 添加店辅
     *
     * @param array $attributes
     * @return boolean
     */
    public function addShop($attributes)
    {
        if(!empty($attributes)){
            $shop = new Shop();
            foreach($attributes as $key=>$value){
                $shop[$key] = $value;
            }
            $shop['ctime'] = time();
            return $shop->save();
        }
        return false;
    }
}