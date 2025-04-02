<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.dummyDAO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');

	class dummyVO extends commonObject{
		var $count;
		var $is_dummy;
		var $start_num;

		/*
		* user var
		*/
		var $uid;
		var $user_id;
		var $user_password;
		var $user_nickname;
		var $user_email;
		var $user_role;

		var $bid;

		var $board_count;
		var $bcid;

		function __construct()
		{
			$this->com = new common();
			$this->dao = new dummyDAO();
			$this->setis_dummy(1);
		}

		function set_count($count){
			$this->setcount($count);
		}

		function set_user_dummy(){
			$this->setuser_password($this->com->aes128_encode('test_dummy'));
		}
		function set_board_dummy(){
			$this->setbid($this->set_max_id(2));
		}
		function set_board_comment_dummy(){
			$this->setboard_count($this->chk_count(2));
			$this->setbcid($this->chk_count(3));
		}

		/*
		* mode
		* 1 == user
		* 2 == board
		* 3 == board_comment
		*/
		function insert($mode=1, $count=1){
			$this->setstart_num($this->last_cnt($mode));
			$this->setcount($count+$this->getstart_num()-1);
			
			if($mode==1){
				$this->set_user_dummy();
			}
			if($mode==2){
				$this->set_board_dummy();
			}
			if($mode==3){
				$this->set_board_comment_dummy();
			}
			$res = $this->dao->insert_dummy($this, $mode);
			return $res;
		}

		/*
		* mode
		* 1 == user
		* 2 == board
		* 3 == board_comment
		*/
		function delete($mode=1){
			$res = $this->dao->delete_dummy($this, $mode);

			return $res;
		}

		/*
		* mode
		* 1 == user
		* 2 == board
		* 3 == board_comment
		*/
		function count_del($mode=1){
			$res = $this->dao->f_del_dum($this, $mode);

			return $res;
		}
		function chk_count($mode=1){
			$res = $this->dao->count($this, $mode);
			return $res;
		}

		function set_ai($mode=1){//AutoIncrement 제어
			$res = $this->dao->alterAI($this, $mode);
			return $res;
		}

		function set_max_id($mode=1){
			$res = $this->dao->setid($this, $mode);
			return $res;
		}

		function last_cnt($mode=1){
			$res = $this->dao->for_last_cnt($this, $mode);
			$start_num = str_replace('test_dummy', '', $res);
			return $start_num+1;
		}

		function del_cash($mode=1){
			$res = $this->dao->alter_cash($this, $mode);
			return $res;
		}

		function optm($mode=1){
			$res = $this->dao->optimize_table($mode);
			return $res;
		}

		function getcount(){return $this->count;}
		function setcount($arg){$this->count = $arg; return $this->count;}
		function getis_dummy(){return $this->is_dummy;}
		function setis_dummy($arg){$this->is_dummy = $arg; return $this->is_dummy;}
		function getstart_num(){return $this->start_num;}
		function setstart_num($arg){$this->start_num = $arg; return $this->start_num;}

		/*
		* user get/set
		*/
		function getuser_password(){return $this->user_password;}
		function setuser_password($arg){$this->user_password = $arg; return $this->user_password;}

		/*
		* board get/set
		*/
		function getbid(){return $this->bid;}
		function setbid($arg){$this->bid=$arg; return $this->bid;}

		function getboard_count(){return $this->board_count;}
		function setboard_count($arg){$this->board_count=$arg; return $this->board_count;}
		function getbcid(){return $this->bcid;}
		function setbcid($arg){$this->bcid=$arg; return $this->bcid;}
	}
?>