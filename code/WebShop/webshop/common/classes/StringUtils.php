<?php
/**
 * 字符串操作公用函数类
 * 
 * @author yaoxianjin
 * Date:2012-10-23
 * Time:17:03
 */
class StringUtils
{
	/**
	 * 不支持创建实例
	 */
	private function __construct(){}
	
	/**
	 * 字符串截取
	 *
	 * @param string $text
	 * @param int $length
	 * @param string $fill
	 * @return string $text
	 */
	public static function truncateText($text, $length, $fill='...')
	{
		if(mb_strlen($text,'utf-8') > $length){
			$text = mb_substr($text, 0, $length, 'utf-8');
			return $text . $fill;
		}else{
			return $text;
		}
	}
	
	/**
	 * 获取字符串长度
	 * 
	 * @param string $value
	 * @return int
	 */
	public static function getRealLength($value)
	{
		return mb_strlen($value, 'utf-8');	
	}
	
	/**
	 * 是否为空，排除0
	 * 
	 * @param string $value
     * @return boolean
	 */
	public static function isEmpty($value)
	{
		return empty($value) && $value != '0';
	}

    /**
     * 判断是否为email
     *
     * @param string $value
     */
    public static function isEmail($value)
    {
        $pattern = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';
         return preg_match($pattern, $value);
    }
	
}