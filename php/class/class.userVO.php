<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.userDAO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');

	class userVO extends commonObject{
		var $uid;
		var $user_id;
		var $user_password;
		var $user_nickname;
		var $user_email;
		var $AUTO_INCREMENT;

		function __construct()
		{
			$this->com = new common();
			$this->dao = new userDAO();
		}

		function reg_con($user_id, $user_password, $user_nickname, $user_email){//ȸ�������� �� �� ������ �ֱ�
			$this->setuser_id($user_id);
			$this->setuser_password($this->com->aes128_encode($user_password));
			$this->setuser_nickname($user_nickname);
			$this->setuser_email($user_email);
		}
		function uid_con($uid){//uid ������ �ֱ�
			$this->setuid($uid);
		}
		function user_nickname_con($user_nickname){//nickname ������ �ֱ�
			$this->setuser_nickname($user_nickname);
		}
		function user_id_con($user_id){//user_id ������ �ֱ�
			$this->setuser_id($user_id);
		}
		function user_email_con($user_email){//user_email ������ �ֱ�
			$this->setuser_email($user_email);
		}
		function user_id_password_con($user_id, $user_password){//user_id, user_password ������ �ֱ�
			$this->setuser_id($user_id);
			$this->setuser_password($this->com->aes128_encode($user_password));
		}
		function user_id_nickname_con($user_id, $user_nickname){//user_id, user_nickname ������ �ֱ�
			$this->setuser_id($user_id);
			$this->setuser_nickname($user_nickname);
		}
		function user_id_email_con($user_id, $user_email){//user_id, user_email ������ �ֱ�
			$this->setuser_id($user_id);
			$this->setuser_email($user_email);
		}

		function insert(){
			$res = $this->dao->insertInfo($this);
			return $res;
		}

		/*
		*mode
		* 1 == user_nickname ���
		* 2 == user_id ���
		* 3 == user_email ���
		*/
		function selectList($search=array(), $mode=1){
			$res = $this->dao->selectListInfo($this, $search, $mode);
			return $res;
		}

		/*
		*mode
		* 1 == user_password ������Ʈ
		* 2 == user_nickname ������Ʈ
		* 3 == user_email ������Ʈ
		* 4 == user_role ������Ʈ
		* 5 == user_id ������Ʈ
		*/
		function update($mode=1){
			$res = $this->dao->updateInfo($this, $mode);
			return $res;
		}

		function set_ai(){//AutoIncrement ����
			$res = $this->dao->alterAI($this);
			return $res;
		}

		function delete(){
			$res = $this->dao->deleteInfo($this);
			return $res;
		}

		function getuid(){return $this->uid;}
		function setuid($arg){$this->uid = $arg; return $this->uid;}
		function getuser_id(){return $this->user_id;}
		function setuser_id($arg){$this->user_id = $arg; return $this->user_id;}
		function getuser_password(){return $this->user_password;}
		function setuser_password($arg){$this->user_password = $arg; return $this->user_password;}
		function getuser_nickname(){return $this->user_nickname;}
		function setuser_nickname($arg){$this->user_nickname = $arg; return $this->user_nickname;}
		function getuser_email(){return $this->user_email;}
		function setuser_email($arg){$this->user_email = $arg; return $this->user_email;}
		function getAUTO_INCREMENT(){return $this->AUTO_INCREMENT;}
		function setAUTO_INCREMENT($arg){$this->AUTO_INCREMENT = $arg; return $this->AUTO_INCREMENT;}
	}
?>