<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	protected $_id;
	protected $user_type;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$user = User::model ()->find ( "user_name=:user_name", array (
				':user_name' => $this->username 
		) );
		// print_r($user);exit;
		if ($user == null)
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		else if ($user->password !== md5 ( $this->password ))
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		else if ($user->status)
			$this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
		else if ($user->open_state)
			$this->errorCode = self::ERROR_UNKNOWN_IDENTITY;
			// else if(!$user->getRoleName($user->user_id))
			// $this->errorCode = 403;
		else {
			$this->errorCode = self::ERROR_NONE;
			$this->_id = $user->user_id;
			$this->username = $user->user_name;
			$this->user_type = $user->user_type;
        }
        
		return !$this->errorCode;
	}
	
	public function getId()
	{
		return $this->_id;
	}
	
	public function getUserType(){
		return $this->user_type;
	}
}