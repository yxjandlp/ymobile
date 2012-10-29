<?php
/**
 * Service工厂类
 * 
 * @author yaoxianjin
 * Date:12-10-19
 * Time:下午3:47
 */
class ServiceFactory
{
	/**
	 * 保存service的静态数组
	 */
	private static $services = array ();
	
	/**
	 * 获取相应类名的service实例
	 *
	 * @param string $className 
	 * @return Service
	 */
	private static function getServiceInstance($className) 
	{
		if (! isset( self::$services [$className] )) {
			self::$services [$className] = new $className();
		}
		return self::$services [$className];
	}
	
	/**
	 * 获得UserService
	 *
	 * @return UserService
	 */
	public static function getUserService() 
	{
		return self::getServiceInstance( 'UserService' );
	}
	
	/**
	 * 获得NiupiService
	 * 
	 * @return NiupiService
	 */
	public static function getNiupiService()
	{
        return self::getServiceInstance( 'NiupiService' );
	}

    /**
     * 获得VoteService
     *
     * @return VoteService
     */
    public static function getVoteService()
    {
        return self::getServiceInstance( 'VoteService' );
    }
}