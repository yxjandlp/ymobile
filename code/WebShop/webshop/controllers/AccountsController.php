<?php
/**
 * 帐号控制器
 * 
 * @author yaoxianjin
 * Date: 2012-10-29
 * Time: 下午4:30 
 */
class AccountsController extends BaseController
{
	/**
	 * 选择布局文件
	 */
	public $layout = "//layouts/accounts";
	
	/**
	 * 错误数组
	 */
	private $_errorArray = array(
			'email' => '',
			'nickname' => '',
			'password' => '',
			'login' => ''
	);

    /**
     * 过滤器
     * @return array
     */
    public function filters()
    {
        return array(
            'ajaxOnly + ajaxIsEmailUsed',
            'ajaxOnly + ajaxIsNicknameUsed',
        );
    }

    /**
	 * 登录
	 */
	public function actionLogin()
	{
		$this->setPageTitle('登录');
        $model = new UserForm('login');
        $loginInfoArray = $this->getRequestParam('UserForm');
        if($loginInfoArray){
            $model->attributes = $loginInfoArray;
            if($model->validate() && $model->login()){
                $backTo = $this->getRequestParam('back_to');
                if(! empty($backTo)){
                    $this->redirect($backTo);
                }else{
                    $this->redirect(Yii::app()->user->returnUrl);
                }
            }
        }
        $this->render('login',array(
            'model' => $model,
        ));
	}
	
	/**
	 * 注册
	 */
	public function actionRegister()
	{
		$this->setPageTitle('注册');
		$registerInfo = $this->getRequestParam('User');
		if( ! empty($registerInfo) && $this->validateRegister($registerInfo) ){
			if(ServiceFactory::getUserService()->addUser($registerInfo)){
				$this->redirect('registerSuccess');
			}
		}
		$this->render('register', array(
			'errorArray' => $this->_errorArray
		));
	}
	
	/**
	 * 注册成功
	 */
	public function actionRegisterSuccess()
	{
		$this->setPageTitle('注册成功');
		$this->render('registerSuccess', array());
	}
	
	/**
	 * 注销
	 */
	public function actionLogout()
	{
		$this->setPageTitle('注销');
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	/**
	 * 验证注册信息
	 * 
	 * @param array $registerInfo
	 */
	private function validateRegister($registerInfo)
	{
		$this->_errorArray['email'] = $this->validateEmail(trim($registerInfo['email']));
		$this->_errorArray['nickname'] = $this->validateNickname(trim($registerInfo['nickname']));
		$this->_errorArray['password'] = $this->validateNickname(trim($registerInfo['password']));
		return ! ($this->_errorArray['email'] || $this->_errorArray['nickname'] || $this->_errorArray['password']);
	}
	
	/**
	 * 验证email输入
	 * 
	 * @param string $email
     * @return string
	 */
	private function validateEmail($email)
	{
		if($email == ''){
			return 'email不能为空';
		}
		if( ! StringUtils::isEmail($email) ){
			return 'email格式错误';
		}
		if($this->isEmailUsed($email)){
			return '该email已被注册';
		}
		return '';
	}
	
	/**
	 * 验证昵称输入
	 * 
	 * @param string $nickname
	 */
	private function validateNickname($nickname)
	{
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
		return '';
	}
	
	/**
	 * 验证密码输入
	 * 
	 * @param string $password
	 */
	private function validatePassword($password)
	{
		if($password == ''){
			return '密码不能为空';
		}
		if(strlen($password) < 6){
			return '密码最少为6位';
		}	
		return '';
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
	
	/**
	 * ajax判断邮箱是否已被注册
	 */
	public function actionAjaxIsEmailUsed()
	{
		$email = $this->getRequestParam('email');
		echo $this->isEmailUsed($email);
	}
	
	/**
	 * ajax判断昵称是否已被使用
	 */
	public function actionAjaxIsNicknameUsed()
	{
		$nickname = $this->getRequestParam('nickname');
		echo $this->isNicknameUsed($nickname);
	}
}