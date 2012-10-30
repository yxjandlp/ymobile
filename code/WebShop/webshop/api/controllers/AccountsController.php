<?php
/**
 * 帐号处理接口
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
				'nickname' => $this->getNick(),
				'password' => $this->getPassword()
		);
    	if(ServiceFactory::getUserService()->addUser($registerInfo)){
			$this->returnSuccessResponse();
		}
	}
	
	/**
	 * 登录
	 */
	public function actionLogin()
	{
		$email = trim($this->getRequestParam('email'));
		if($email == ''){
			$this->returnErrorCode(ApiCode::REGISTER_EMAIL_CANNOT_LEAVE_EMPTY);
		}
		$password = $this->getRequestParam('password');
		if($password == ''){
			$this->returnErrorCode(ApiCode::REGISTER_PASSWORD_CANNOT_LEAVE_EMPTY);
		}
		$user = ServiceFactory::getUserService()->getUserByEmailPwd($email, $password);
		if(! $user){
			$this->returnErrorCode(ApiCode::LOGIN_WRONG_EMAIL_OR_PASSWORD);
		}
		$this->returnSuccessResponse(array('id'=>$user['id'], 'nickname'=>$user['nickname']));	
	}
	
	/**
	 * 验证email输入
	 */
	private function getEmail()
	{
		$email = trim($this->getRequestParam('email'));
		if($email == ''){
			$this->returnErrorCode(ApiCode::REGISTER_EMAIL_CANNOT_LEAVE_EMPTY);
		}
		if( ! StringUtils::isEmail($email) ){
			$this->returnErrorCode(ApiCode::REGISTER_EMAIL_ILLEGAL_FORMAT);
		}
		if($this->isEmailUsed($email)){
			$this->returnErrorCode(ApiCode::REGISTER_EMAIL_ALREADY_BEEN_USED);
		}
		return $email;
	}
	
	/**
	 * 验证昵称输入
	 */
 	private function getNick()
	{
 		$nickname = trim($this->getRequestParam('nickname'));
		if($nickname == ''){
			$this->returnErrorCode(ApiCode::REGISTER_NICKNAME_CANNOT_LEAVE_EMPTY);
		}
		if(StringUtils::getRealLength($nickname) > 16){
			$this->returnErrorCode(ApiCode::REGISTER_NICKNAME_LENGTH_TOO_LONG);
		}
		$pattern = '/^[0-9a-zA-Z\\x80-\\xff_]*$/';
		if( ! preg_match($pattern, $nickname) ){
			$this->returnErrorCode(ApiCode::REGISTER_NICKNAME_ILLEGAL_FORMAT);
		}
		if($this->isNicknameUsed($nickname)){
			$this->returnErrorCode(ApiCode::REGISTER_NICKNAME_ALREADY_BEEN_USED);
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
			$this->returnErrorCode(ApiCode::REGISTER_PASSWORD_CANNOT_LEAVE_EMPTY);
		}
		if(strlen($password) < 6){
			$this->returnErrorCode(ApiCode::REGISTER_PASSWORD_LENGTH_TOO_SHORT);
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