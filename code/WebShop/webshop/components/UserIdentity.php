<?php
/**
 * 用户验证类
 * 
 * @author yaoxianjin
 * Date: 2012-10-18
 * Time: 17:31
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * 用户数据库记录id
	 */
    private $_id;
    
    /**
     * 用户邮箱
     */
    private $_email;
    
    /**
     * 用户昵称
     */
    private $_nickname;
    
    /**
     * 用户角色
     */
    private $_role = 'member';

	/**
	 * 验证用户
	 * 
	 * @return boolean
	 */
	public function authenticate()
	{
        $user=User::model()->find('LOWER(email)=?', array(strtolower(trim($this->username))));
        if( $user == null )
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if($user['password'] != sha1($this->password))
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
        {
            $this->_id=$user->id;
            $this->_email=$user->email;
            $this->_nickname=$user->nickname;
            Yii::app()->user->setState('role',$this->_role);
            $this->errorCode=self::ERROR_NONE;
        }
        return $this->errorCode==self::ERROR_NONE;
	}

	/**
	 * 获取登录用户的ID
	 * 
	 * @return int ID
	 */
    public function getId()
    {
        return $this->_id;
    }

    /**
	 * 获取登录用户的用户名
	 * 
	 * @return string
     */
    public function getName()
    {
        return $this->_nickname;
    }
    
}