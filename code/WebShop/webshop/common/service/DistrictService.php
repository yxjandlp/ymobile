<?php
/**
 * 地区Service
 * 
 * @author yaoxianjin
 * Date: 2012-11-20
 * Time: 17:08
 */
class DistrictService extends ActionService
{
	/**
	 * 根据级别获取地区
	 * 
	 * @param int $level
	 * @return Array
	 */
	public function getByLevel($level)
	{
		return District::model()->findAll('level=:level', array(':level'=>$level));
	}
	
	/**
	 * 获取子地区
	 * 
	 * @parem $upLevelId
	 * @return Array
	 */
	public function getChildren($upLevelId)
	{
		return District::model()->findAll('upid=:upid', array(':upid'=>$upLevelId));
	}
}