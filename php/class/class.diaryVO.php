<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.diaryDAO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');

	class diaryVO extends commonObject{
		/*
		*	diary_user var
		*/
		var $did;
		var $d_writer;
		var $d_password;

		/*
		*	diary_list var
		*/
		var $dlid;
		var $f_did;
		var $dl_title;
		var $dl_body;
		var $dl_date;
		var $dl_imgp;

		function __construct()
		{
			$this->dao = new diaryDAO();
			$this->com = new common();
		}

		function diary_user_set($d_writer, $d_password){
			$this->setdid($this->set_max_id(1)+1);
			$this->setd_writer($d_writer);
			$this->setd_password($this->com->sha256_encode($d_password));
		}

		function diary_list_set($f_did, $dl_title, $dl_body, $dl_date){
			$this->setf_did($f_did);
			$this->setdl_title($dl_title);
			$this->setdl_body($dl_body);
			$this->setdl_date($dl_date);
		}

		function diary_list_upd_set($dlid, $dl_title, $dl_body){
			$this->setdlid($dlid);
			$this->setdl_title($dl_title);
			$this->setdl_body($dl_body);
		}

		function img_set($img_name, $dir_path){
			$img = $this->com->setimg_path($img_name, $dir_path);

			return $this->setdl_imgp($img);
		}

		function insert($mode=1){
			$res = $this->dao->insert_diary($this, $mode);

			return $res;
		}

		function select($mode=1, $start_num=null, $sp_max=null){
			$res = $this->dao->select_diary($this, $mode, $start_num, $sp_max);

			return $res;
		}

		function where_select($mode=1, $where=null, $start_num=null, $sp_max=null){
			$res = $this->dao->where_select_diary($this, $mode, $where, $start_num, $sp_max);

			return $res;
		}

		function update($mode=1){
			$res = $this->dao->update_diary($this, $mode);

			return $res;
		}

		function delete($mode=1){
			$res = $this->dao->delete_diary($this, $mode);

			return $res;
		}

		function set_max_id($mode){
			$res = $this->dao->max_id($this, $mode);

			return $res;
		}

		function set_ai(){
			$res = $this->dao->alterAI($this);

			return $res;
		}
		
		function getdid(){return $this->did;}
		function setdid($arg){$this->did=$arg; return $this->did;}
		function getd_writer(){return $this->d_writer;}
		function setd_writer($arg){$this->d_writer=$arg; return $this->d_writer;}
		function getd_password(){return $this->d_password;}
		function setd_password($arg){$this->d_password=$arg; return $this->d_password;}

		function getdlid(){return $this->dlid;}
		function setdlid($arg){$this->dlid=$arg; return $this->dlid;}
		function getf_did(){return $this->f_did;}
		function setf_did($arg){$this->f_did=$arg; return $this->f_did;}
		function getdl_title(){return $this->dl_title;}
		function setdl_title($arg){$this->dl_title=$arg; return $this->dl_title;}
		function getdl_body(){return $this->dl_body;}
		function setdl_body($arg){$this->dl_body=$arg; return $this->dl_body;}
		function getdl_date(){return $this->dl_date;}
		function setdl_date($arg){$this->dl_date=$arg; return $this->dl_date;}
		function getdl_imgp(){return $this->dl_imgp;}
		function setdl_imgp($arg){$this->dl_imgp=$arg; return $this->dl_imgp;}
	}
?>