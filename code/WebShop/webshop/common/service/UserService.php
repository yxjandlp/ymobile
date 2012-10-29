<?php
/**
 * 用户操作Service
 * 
 * @author yaoxianjin
 * Date: 2012-10-19
 * Time: 15:53
 */
class UserService extends ActionService
{
	/**
	 * 根据邮箱获取用户信息
	 *
	 * @param string $email
	 */
	public function getUserByEmail($email)
	{
		return User::model()->find('email=:email', array(':email'=>$email));
	}
	
	/**
	 * 根据昵称获取用户信息 
	 * 
	 * @param string $nickname
	 */
	public function getUserByNickname($nickname)
	{
		return User::model()->find('nickname=:nickname', array(':nickname'=>$nickname));
	}
	
	/**
	 * 添加用户
	 * 
	 * @param array $attributes
	 */
	public function addUser($attributes)
	{
		$user = new User();
		foreach($attributes as $key=>$value){
			$user[$key] = $value;
		}
		$user['password'] = sha1($user['password']);
		$user['join_time'] = time();
		return $user->save();
	}
}