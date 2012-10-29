<?php
/**
 * 帐号控制器
 * 
 * @author yaoxianjin
 * Date: 2012-10-29
 * Time: 下午4:30 
 */
class AccountsController extends ApiBaseController
{
	/**
	 * 注册
	 */
	public function actionRegister()
	{
 		$registerInfo = array(
				'email' => $this->getEmail(),
				'nickname' => $this->getNickname(),
				'password' => $this->getPassword()
		);
    	if(ServiceFactory::getUserService()->addUser($registerInfo)){
			$this->returnSuccessResponse();
		}
	}
	
	/**
	 * 验证email输入
	 */
	private function getEmail()
	{
		$email = $this->getRequestParam('email');
		if($email == ''){
			return 'email不能为空';
		}
		if( ! StringUtils::isEmail($email) ){
			return 'email格式错误';
		}
		if($this->isEmailUsed($email)){
			return '该email已被注册';
		}
		return $email;
	}
	
	/**
	 * 验证昵称输入
	 */
 	private function getNick()
	{
 		$nickname = $this->getRequestParam('nickname');
		if($nickname == ''){
			return '昵称不能为空';
		}
		if(StringUtils::getRealLength($nickname) > 16){
			return '昵称过长，最长为16位';
		}
		$pattern = '/^[0-9a-zA-Z\\x80-\\xff_]*$/';
		if( ! preg_match($pattern, $nickname) ){
			return '昵称格式错误，需为昵1－16位的中英文、数字或_';
		}
		if($this->isNicknameUsed($nickname)){
			return '该昵称已被使用';
		}
		return $nickname;
	}
	
	/**
	 * 验证密码输入
	 * 
	 * @param string $password
	 */
	private function getPassword()
	{
		$password = $this->getRequestParam('password');
		if($password == ''){
			return '密码不能为空';
		}
		if(strlen($password) < 6){
			return '密码最少为6位';
		}	
		return $password;
	}
	
	/**
	 * 判断邮箱是否已被注册
	 * 
	 * @param string $email
	 * @return int flag （1代表已注册，0代表未注册）
	 */
	private function isEmailUsed($email)
	{
		$user = ServiceFactory::getUserService()->getUserByEmail($email);
		return $user ? 1 : 0;
	}
	
	/**
	 * 判断昵称是否已被使用
	 * 
	 * @param string $nickname
	 * @return int flag
	 */
	private function isNicknameUsed($nickname)
	{
		$user = ServiceFactory::getUserService()->getUserByNickname($nickname);
		return $user ? 1 : 0;
	}
}