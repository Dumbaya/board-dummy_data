<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.adminDAO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');

	class adminVO extends commonObject{
		var $uid;
		var $user_id;
		var $user_password;
		var $user_nickname;
		var $user_email;
		var $user_role;
		var $AUTO_INCREMENT;
		var $last_uid;

		function __construct()
		{
			$this->com = new common();
			$this->dao = new adminDAO();
		}

		/*
		* mode
		* 1 == 모든 유저 찾기
		* 2 == 유저 권한 1인 유저들 카운트
		* 3 == uid를 이용한 유저 찾기
		*/
		function selectUser($mode=1, $start_num=null, $sp_max=null){
			$res = $this->dao->selectUser($this, $mode, $start_num, $sp_max);
			return $res;
		}

		/*
		*mode
		* 1 == user_password 업데이트
		* 2 == user_nickname 업데이트
		* 3 == user_email 업데이트
		* 4 == user_role 업데이트
		* 5 == user_id 업데이트
		*/
		function updateUser($mode=1){
			$res = $this->dao->updateUser($this, $mode);
			return $res;
		}

		function deleteUser(){
			$res = $this->dao->deleteUser($this);
			return $res;
		}

		function getuid(){return $this->uid;}
		function setuid($arg){$this->uid = $arg; return $this->uid;}
		function getuser_id(){return $this->user_id;}
		function setuser_id($arg){$this->user_id = $arg; return $this->user_id;}
		function getuser_password(){return $this->user_password;}
		function setuser_password($arg){$this->user_password = $this->com->aes128_encode($arg); return $this->user_password;}
		function getuser_nickname(){return $this->user_nickname;}
		function setuser_nickname($arg){$this->user_nickname = $arg; return $this->user_nickname;}
		function getuser_email(){return $this->user_email;}
		function setuser_email($arg){$this->user_email = $arg; return $this->user_email;}
		function getuser_role(){return $this->user_role;}
		function setuser_role($arg){$this->user_role = $arg; return $this->user_role;}
		function getAUTO_INCREMENT(){return $this->AUTO_INCREMENT;}
		function setAUTO_INCREMENT($arg){$this->AUTO_INCREMENT = $arg; return $this->AUTO_INCREMENT;}
		function getlast_uid(){return $this->last_uid;}
		function setlast_uid($arg){$this->last_uid = $arg; return $this->last_uid;}
	}
?>