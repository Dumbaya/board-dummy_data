<?
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.boardDAO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');

	class boardVO extends commonObject{
		/*
		* announ_board var
		*/
		var $aid;
		var $a_title;
		var $a_body;
		var $a_writer;
		var $a_date;
		var $a_imgp;

		/*
		* board var
		*/
		var $bid;
		var $board_title;
		var $board_writer;
		var $board_body;
		var $board_date;
		var $board_imgp;

		/*
		* board_comment var
		*/
		var $f_bid;
		var $bcid;
		var $pa_bcid;
		var $group_id;
		var $group_o;
		var $depth;
		var $bc_comment;
		var $bc_writer;
		var $bc_date;
		var $bc_gb;
		var $is_delete;

		/*
		*	board_gb var
		*/
		var $bgbid;
		var $bg_user;
		var $bg_check;

		/*
		*	board_comment_gb var
		*/
		var $f_bcid;
		var $bcgbid;
		var $bcgb_user;
		var $bcgb_check;

		var $where;
		var $AUTO_INCREMENT;
		var $newi;
		var $last_bid;
		var $last_board_date;

		function __construct()
		{
			$this->com = new common();
			$this->dao = new boardDAO();
		}

		function announ_set($announ_title, $announ_body, $announ_writer, $announ_date){
			$this->seta_title($announ_title);
			$this->seta_body($announ_body);
			$this->seta_writer($announ_writer);
			$this->seta_date($announ_date);
		}
		function up_announ_set($aid, $announ_title, $announ_body){
			$this->setaid($aid);
			$this->seta_title($announ_title);
			$this->seta_body($announ_body);
		}

		function board_set($board_title, $board_writer, $board_body, $board_date){
			$bid = $this->set_max_id(1);
			$this->setbid($bid);
			$this->setboard_title($board_title);
			$this->setboard_writer($board_writer);
			$this->setboard_body($board_body);
			$this->setboard_date($board_date);
		}
		function up_board_set($bid, $board_title, $board_body){
			$this->setbid($bid);
			$this->setboard_title($board_title);
			$this->setboard_body($board_body);
		}

		function bg_set($f_bid, $bgbid, $bg_user, $bg_check){
			$this->setf_bid($f_bid);
			$this->setbgbid($bgbid);
			$this->setbg_user($bg_user);
			$this->setbg_check($bg_check);
		}

		function bc_set($f_bid, $bcid, $group_id, $bc_comment, $bc_writer, $bc_date){
			$this->setf_bid($f_bid);
			$this->setbcid($bcid);
			$this->setgroup_id($group_id);
			$this->setbc_comment($bc_comment);
			$this->setbc_writer($bc_writer);
			$this->setbc_date($bc_date);
		}

		function bcc_set($f_bid, $bcid, $pa_bcid, $group_id){
			$this->setf_bid($f_bid);
			$this->setbcid($bcid);
			$this->setpa_bcid($pa_bcid);
			$this->setgroup_id($group_id);
		}
		function bcc_final_set($f_bid, $bcid, $pa_bcid, $group_id, $group_o, $depth, $bc_comment, $bc_writer, $bc_date){
			$this->setf_bid($f_bid);
			$this->setbcid($bcid);
			$this->setpa_bcid($pa_bcid);
			$this->setgroup_id($group_id);
			$this->setgroup_o($group_o);
			$this->setdepth($depth);
			$this->setbc_comment($bc_comment);
			$this->setbc_writer($bc_writer);
			$this->setbc_date($bc_date);
		}

		function bc_upd_set($bcid, $bc_comment){
			$this->setbcid($bcid);
			$this->setbc_comment($bc_comment);
		}

		function bcgb_set($f_bid, $f_bcid, $bcgbid, $bcgb_user, $bcgb_check){
			$this->setf_bid($f_bid);
			$this->setbcid($f_bcid);
			$this->setf_bcid($f_bcid);
			$this->setbcgbid($bcgbid);
			$this->setbcgb_user($bcgb_user);
			$this->setbcgb_check($bcgb_check);
		}

		/*
		* mode
		* 1 == board
		* 2 == announ_board
		*/
		function img_set($img_name, $dir_path, $mode=1){
			$img = $this->com->setimg_path($img_name, $dir_path);

			if($mode==1){
				$this->setboard_imgp($img);
			}
			else if($mode==2){
				$this->seta_imgp($img);
			}
		}

		/*
		* mode
		* 1 == board insert
		* 2 == announ_board insert
		* 3 == board_comment insert
		* 4 == board_gb insert
		*/
		function insert($mode=1){
			$res = $this->dao->insert_board($this, $mode);
			return $res;
		}

		/*
		* mode
		* 1 == board 전체 데이터 가져오기
		* 2 == board 전체 데이터 카운트 가져오기
		* 3 == announ_board 전체 데이터 가져오기
		* 4 == announ_board 전체 데이터 카운트 가져오기
		* 5 == board 전체 데이터 페이징
		* 6 == board_comment 해당 bid 카운트 가져오기
		* 7 == announ board 해당 aid 데이터 가져오기
		* 8 == board 해당 bid 데이터 가져오기
		* 9 == board 해당 board_writer 카운트 가져오기
		* 10 == board 해당 board_writer 데이터 가져오기
		* 11 == board_comment 해당 bc_writer 카운트 가져오기
		* 12 == board_comment 해당 bc_writer 데이터 가져오기
		* 13 == board 해당 board_writer 데이터 페이징
		* 14 == board_comment 해당 bc_writer 데이터 페이징
		* 15 == board_comment 특정 값 depth 찾기
		* 16 == board_comment 특정 값 group_o MAX 값 찾기
		*/
		function select($mode=1, $start_num=null , $sp_max=null){
			$res = $this->dao->select_board($this, $mode, $start_num, $sp_max);
			return $res;
		}

		/*
		* mode
		* 1 == board search 데이터 카운트 가져오기
		* 2 == board search 데이터 가져오기
		*/
		function search_select($mode=1, $where=null, $start_num=null , $sp_max=null){
			$res = $this->dao->search_select_board($this, $mode, $where, $start_num, $sp_max);

			return $res;
		}

		/*
		* mode
		* 1 == board_gb
		* 2 == board_comment_gb
		*/
		function check_select($mode=1){
			$res = $this->dao->bg_check_select($this, $mode);

			return $res;
		}

		/*
		* mode
		* 1 == announ_board update
		* 2 == board update
		*/
		function update($mode=1){
			$res = $this->dao->update_board($this, $mode);

			return $res;
		}

		/*
		* mode
		* 1 == announ_board update
		* 2 == board update
		*/
		function delete($mode=1){
			$res = $this->dao->delete_board($this, $mode);

			return $res;
		}

		function set_ai(){
			$res = $this->dao->alterAI($this);
			return $res;
		}

		/*
		* mode
		* 1 == board
		* 2 == board_comment
		* 3 == board_gb
		* 4 == board_comment_gb
		*/
		function set_max_id($mode=1){
			$res = $this->dao->setid($this, $mode);
			return $res+1;
		}

		/*
		* board get/set
		*/
		function getbid(){return $this->bid;}
		function setbid($arg){$this->bid=$arg; return $this->bid;}
		function getboard_title(){return $this->board_title;}
		function setboard_title($arg){$this->board_title=$arg; return $this->board_title;}
		function getboard_writer(){return $this->board_writer;}
		function setboard_writer($arg){$this->board_writer=$arg; return $this->board_writer;}
		functioN getboard_body(){return $this->board_body;}
		function setboard_body($arg){$this->board_body=$arg; return $this->board_body;}
		functioN getboard_date(){return $this->board_date;}
		function setboard_date($arg){$this->board_date=$arg; return $this->board_date;}
		function getboard_imgp(){return $this->board_imgp;}
		function setboard_imgp($arg){$this->board_imgp=$arg; return $this->board_imgp;}

		/*
		* board_comment get/set
		*/
		function getf_bid(){return $this->f_bid;}
		function setf_bid($arg){$this->f_bid=$arg; return $this->f_bid;}
		function getbcid(){return $this->bcid;}
		function setbcid($arg){$this->bcid=$arg; return $this->bcid;}
		function getpa_bcid(){return $this->pa_bcid;}
		function setpa_bcid($arg){$this->pa_bcid=$arg; return $this->pa_bcid;}
		function getgroup_id(){return $this->group_id;}
		function setgroup_id($arg){$this->group_id=$arg; return $this->group_id;}
		functioN getgroup_o(){return $this->group_o;}
		function setgroup_o($arg){$this->group_o=$arg; return $this->group_o;}
		functioN getdepth(){return $this->depth;}
		function setdepth($arg){$this->depth=$arg; return $this->depth;}
		function getbc_comment(){return $this->bc_comment;}
		function setbc_comment($arg){$this->bc_comment=$arg; return $this->bc_comment;}
		function getbc_writer(){return $this->bc_writer;}
		function setbc_writer($arg){$this->bc_writer=$arg; return $this->bc_writer;}
		function getbc_date(){return $this->bc_date;}
		function setbc_date($arg){$this->bc_date=$arg; return $this->bc_date;}
		function getbc_gb(){return $this->bc_gb;}
		function setbc_gb($arg){$this->bc_gb=$arg; return $this->bc_gb;}
		function getis_delete(){return $this->is_delete;}
		function setis_delete($arg){$this->is_delete=$arg; return $this->is_delete;}

		/*
		* announ_board get/set
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
		*	board_gb get/set
		*/
		function getbgbid(){return $this->bgbid;}
		function setbgbid($arg){$this->bgbid=$arg; return $this->bgbid;}
		function getbg_user(){return $this->bg_user;}
		function setbg_user($arg){$this->bg_user=$arg; return $this->bg_user;}
		function getbg_Check(){return $this->bg_check;}
		function setbg_check($arg){$this->bg_check=$arg; return $this->bg_check;}

		function getAUTO_INCREMENT(){return $this->AUTO_INCREMENT;}
		function setAUTO_INCREMENT($arg){$this->AUTO_INCREMENT=$arg; return $this->AUTO_INCREMENT;}
		function getnewi(){return $this->newi;}
		function setnewi($arg){$this->newi=$arg; return $this->newi;}

		/*
		*	board_comment_gb get/set
		*/
		function getf_bcid(){return $this->f_bcid;}
		function setf_bcid($arg){$this->f_bcid=$arg; return $this->f_bcid;}
		function getbcgbid(){return $this->bcgbid;}
		function setbcgbid($arg){$this->bcgbid=$arg; return $this->bcgbid;}
		function getbcgb_user(){return $this->bcgb_user;}
		function setbcgb_user($arg){$this->bcgb_user=$arg; return $this->bcgb_user;}
		function getbcgb_check(){return $this->bcgb_check;}
		function setbcgb_check($arg){$this->bcgb_check=$arg; return $this->bcgb_check;}

		function getlast_bid(){return $this->last_bid;}
		function setlast_bid($arg){$this->last_bid=$arg; return $this->last_bid;}
		function getlast_board_date(){return $this->last_board_date;}
		function setlast_board_date($arg){$this->last_board_date=$arg; return $this->last_board_date;}
	}
?>