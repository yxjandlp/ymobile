<?php
/**
 * 店辅分类Service
 * 
 * @author yaoxianjin
 * Date: 2012-11-20
 * Time: 16:20
 */
class CategoryService extends ActionService
{
	/**
	 * 获取所有分类
	 * 
	 * @return array
	 */
	public function getAll()
	{
		return Category::model()->findAll();
	}
}