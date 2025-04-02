<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.bonogaDAO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');

	class bonogaVO extends commonObject{
		/*
		* bonoga var
		*/
		var $iid;
		var $img_path;
		var $img_title;
		var $img_writer;
		var $img_date;
		var $img_gb;

		/*
		* announ_bonoga var
		*/
		var $aid;
		var $a_title;
		var $a_body;
		var $a_writer;
		var $a_date;

		/*
		* bonoga_gb var
		*/
		var $f_iid;
		var $bg_iid;
		var $bg_user;
		var $bg_check;

		function __construct()
		{
			$this->dao = new bonogaDAO();
			$this->com = new common();
		}

		function bonoga_set($img_title, $img_writer, $img_date){
			$this->setiid($this->set_max_id(1)+1);
			$this->setimg_title($img_title);
			$this->setimg_writer($img_writer);
			$this->setimg_date($img_date);
		}

		function img_set($img_name, $dir_path, $mode=1){
			$img = $this->com->setimg_path($img_name, $dir_path);

			if($mode==1){
				$this->setimg_path($img);
			}
			else if($mode==2){
				$this->seta_imgp($img);
			}
		}

		function announ_set($announ_title, $announ_body, $announ_writer, $announ_date){
			$this->seta_title($announ_title);
			$this->seta_body($announ_body);
			$this->seta_writer($announ_writer);
			$this->seta_date($announ_date);
		}

		function announ_upd_set($aid, $a_title, $a_body){
			$this->setaid($aid);
			$this->seta_title($a_title);
			$this->seta_body($a_body);
		}

		function board_gb_set($f_iid, $bg_user, $bg_check){
			$this->setf_iid($f_iid);
			$this->setbg_iid($this->set_max_id(2)+1);
			$this->setbg_user($bg_user);
			$this->setbg_check($bg_check);
		}

		function insert($mode=1){
			$res = $this->dao->insert_bonoga($this, $mode);

			return $res;
		}

		/*
		*	mode
		* 1 == bonoga 전체 테이블 카운팅
		* 2 == bonoga 전체 테이블 페이징 데이터 가져오기
		* 3 == announ_bonoga 전체 테이블 카운팅
		* 4 == announ_bonoga 전체 테이블 데이터 가져오기
		*/
		function select($mode=1, $start_num=null, $sp_max=null){
			$res = $this->dao->select_bonoga($this, $mode, $start_num, $sp_max);

			return $res;
		}

		function where_select($mode=1, $where=null, $start_num=null, $sp_max=null){
			$res = $this->dao->page_select($this, $mode, $where, $start_num, $sp_max);
			
			return $res;
		}

		function update($mode=1){
			$res = $this->dao->update_bonoga($this, $mode);

			return $res;
		}

		function delete($mode=1){
			$res = $this->dao->delete_bonoga($this, $mode);

			return $res;
		}

		function set_max_id($mode=1){
			return $this->dao->max_id($this, $mode);
		}

		function set_ai(){
			$res = $this->dao->alterAI($this);
			return $res;
		}

		/*
		*	bonoga get/set
		*/
		function getiid(){return $this->iid;}
		function setiid($arg){$this->iid=$arg; return $this->iid;}
		function getimg_path(){return $this->img_path;}
		function setimg_path($arg){$this->img_path=$arg; return $this->img_path;}
		function getimg_title(){return $this->img_title;}
		function setimg_title($arg){$this->img_title=$arg; return $this->img_title;}
		function getimg_writer(){return $this->img_writer;}
		function setimg_writer($arg){$this->img_writer=$arg; return $this->img_writer;}
		function getimg_date(){return $this->img_date;}
		function setimg_date($arg){$this->img_date=$arg; return $this->img_date;}
		function getimg_gb(){return $this->img_gb;}
		function setimg_gb($arg){$this->img_gb=$arg; return $this->img_gb;}

		/*
		* announ_bonoga get/set
		*/
		function getaid(){return $this->aid;}
		function setaid($arg){$this->aid=$arg; return $this->aid;}
		function geta_title(){return $this->a_title;}
		function seta_title($arg){$this->a_title=$arg; return $this->a_title;}
		function geta_body(){return $this->a_body;}
		function seta_body($arg){$this->a_body=$arg; return $this->a_body;}
		function geta_writer(){return $this->a_writer;}
		function seta_writer($arg){$this->a_writer=$arg; return $this->a_writer;}
		function geta_date(){return $this->a_date;}
		function seta_date($arg){$this->a_date=$arg; return $this->a_date;}
		function geta_imgp(){return $this->a_imgp;}
		function seta_imgp($arg){$this->a_imgp=$arg; return $this->a_imgp;}

		/*
		* bonoga_gb get/set
		*/
		function getf_iid(){return $this->f_iid;}
		function setf_iid($arg){$this->f_iid=$arg; return $this->f_iid;}
		function getbg_iid(){return $this->bg_iid;}
		function setbg_iid($arg){$this->bg_iid=$arg; return $this->bg_iid;}
		function getbg_user(){return $this->bg_user;}
		function setbg_user($arg){$this->bg_user=$arg; return $this->bg_user;}
		function getbg_check(){return $this->bg_check;}
		function setbg_check($arg){$this->bg_check=$arg; return $this->bg_check;}
	}
?>