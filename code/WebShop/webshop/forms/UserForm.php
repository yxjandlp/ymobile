<?php
/**
 * 用户表单（登录、注册）
 * 
 * @author yaoxianjin
 * Date: 2012-10-29
 * Time: 15:25
 */
class UserForm extends CFormModel
{
	/**
	 * 用户登录邮箱
	 */
	public $email;
	
	/**
	 * 用户昵称
	 */
	public $nickname;
	
	/**
	 * 用户密码
	 */
	public $password;
	
	/**
	 * 自动登录
	 */
	public $rememberMe = false;
	
	/**
	 * 用户认证 
	 */
	private $_identity;
	
	/**
	 * 字段规则
	 */
	public function rules() 
	{
		return array(
				array('email', 'required', 'on'=>'login,register', 'message'=>'邮箱不能为空'),
				array('password', 'required', 'on'=>'login,register', 'message'=>'密码不能为空'),
				array('email', 'checkExistsEmail', 'on'=>'register'),
				array('nickname', 'checkExistsNickname', 'on'=>'register'),
				array('password', 'length', 'min'=>6, 'on'=>'register', 'message'=>'密码长度不能小于6位'),
				array('rememberMe', 'boolean', 'on'=>'login'),
				array('password','authenticate', 'on'=>'login'),
		);
	}
	
	/**
	 * 字段显示标签
	 */
	public function attributeLabels()
	{
		return array(
				'email' => '邮箱',
				'nickname' => '昵称',
				'password' => "密码",
		);
	}
	
	/**
	 * 密码验证
	 */
	public function authenticate($attribute, $params)
	{
		$this->_identity = new UserIdentity($this->email, $this->password);
	
		if( ! $this->_identity->authenticate() ){
			$this->addError('email', "登录邮箱或密码错误");
		}
	}
	
	/**
	 * 用户登录
	 * 
	 * @return boolean
	 */
	public function login()
	{
		if( $this->_identity === null ){
			$this->_identity = new UserIdentity($this->email, $this->password);
			$this->_identity->authenticate();
		}
		if( $this->_identity->errorCode === UserIdentity::ERROR_NONE ){
			$duration = $this->rememberMe ? 3600*24*14 : 0;
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * 判断邮箱是否已被注册
	 */
	public function checkExistsEmail($attribute, $params) 
	{
		if ($this->email) {
			$model = ServiceFactory::getUserService()->getUserByEmail($this->email);
			if ($model) {
				$this->addError('email', "该邮箱已被注册");
			}
		}
	}
	
	/**
	 * 判断昵称是否已被使用
	 */
	public function checkExistsNickname($attribute, $params)
	{
		if ($this->nickname) {
			$model = ServiceFactory::getUserService()->getUserByNickname($this->nickname);
			if ($model) {
				$this->addError('nickname', "该昵称已被使用");
			}
		}
	}
}