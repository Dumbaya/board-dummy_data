<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/DB.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.commonDAO.php');

	class bonogaDAO extends commonDAO{
		private $bonoga_insertQuery = "
			INSERT INTO bonoga(iid, img_path, img_title, img_writer, img_date) VALUES(
				:iid,
				:img_path,
				:img_title,
				:img_writer,
				:img_date
			)
		";

		private $announ_inserQuery = "
			INSERT INTO announ_bonoga(a_title, a_body, a_writer, a_date, a_imgp) VALUES(
				:a_title,
				:a_body,
				:a_writer,
				:a_date,
				:a_imgp
			)
		";

		private $bonoga_gb_insertQuery = "
			INSERT INTO bonoga_gb(f_iid, bg_iid, bg_user, bg_check) VALUES(
				:f_iid,
				:bg_iid,
				:bg_user,
				:bg_check
			)
		";

		private $bonoga_selectQuery = "
			SELECT * FROM bonoga
		";

		private $bonoga_popup_selectQuery = "
			SELECT * FROM bonoga WHERE iid=:iid
		";

		private $bonoga_nickname_selectQuery = "
			SELECT * FROM bonoga WHERE img_writer=:img_writer
		";

		private $announ_bonoga_selectQuery = "
			SELECT * FROM announ_bonoga ORDER BY aid DESC
		";

		private $announ_bonoga_f_selectQuery = "
			SELECT * FROM announ_bonoga WHERE aid=:aid
		";

		private $bonoga_gb_check_selectQuery = "
			SELECT * FROM bonoga_gb WHERE f_iid=:f_iid and bg_user=:bg_user and bg_check=:bg_check
		";

		private $announ_bonoga_updateQuery = "
			UPDATE announ_bonoga SET a_imgp=:a_imgp, a_title=:a_title, a_body=:a_body WHERE aid=:aid
		";

		private $bonoga_updateQuery = "
			UPDATE bonoga SET img_path=:img_path, img_title=:img_title WHERE iid=:iid
		";

		private $bonoga_gb_up_updateQuery = "
			UPDATE bonoga SET img_gb=img_gb+1 WHERE iid=:iid
		";

		private $bonoga_gb_down_updateQuery = "
			UPDATE bonoga SET img_gb=img_gb-1 WHERE iid=:iid
		";

		private $bonoga_deleteQuery = "
			DELETE FROM bonoga WHERE iid=:iid
		";

		private $announ_bonoga_deleteQuery = "
			DELETE FROM announ_bonoga WHERE aid=:aid
		";

		private $bonoga_gb_deleteQuery = "
			DELETE FROM bonoga_gb WHERE f_iid=:f_iid and bg_user=:bg_user and bg_check=:bg_check
		";

		private $max_id_bonoga_selectQuery = "
			SELECT MAX(iid) FROM bonoga
		";

		private $max_bg_iid_selectQuery = "
			SELECT MAX(bg_iid) FROM bonoga_gb
		";

		function insert_bonoga($obj, $mode){
			if($mode==1){
				return $this->insert($this->bonoga_insertQuery, $obj);
			}
			else if($mode==2){
				return $this->insert($this->announ_inserQuery, $obj);
			}
			else if($mode==3){
				return $this->insert($this->bonoga_gb_insertQuery, $obj);
			}
		}

		/*
		*	mode
		* 1 == bonoga 전체 테이블 카운팅
		* 2 == bonoga 전체 테이블 페이징 데이터 가져오기
		* 3 == announ_bonoga 전체 테이블 카운팅
		* 4 == announ_bonoga 전체 테이블 데이터 가져오기
		*/
		function select_bonoga($obj, $mode, $start_num, $sp_max){
			if($mode==1){
				return $this->count_select($this->bonoga_selectQuery, $obj);
			}
			else if($mode==2){
				$query = $this->bonoga_selectQuery;
				$query .= " order by iid desc limit $start_num, $sp_max";

				return $this->select($query, $obj);
			}
			else if($mode==3){
				return $this->count_select($this->announ_bonoga_selectQuery, $obj);
			}
			else if($mode==4){
				return $this->select($this->announ_bonoga_selectQuery, $obj);
			}
			else if($mode==5){
				return $this->select($this->bonoga_popup_selectQuery, $obj);
			}
			else if($mode==6){
				return $this->select($this->announ_bonoga_f_selectQuery, $obj);
			}
			else if($mode==7){
				return $this->count_select($this->bonoga_gb_check_selectQuery, $obj);
			}
			else if($mode==8){
				return $this->count_select($this->bonoga_nickname_selectQuery, $obj);
			}
			else if($mode==9){
				$query = $this->bonoga_nickname_selectQuery;
				$query .= " ORDER BY iid DESC LIMIT $start_num, $sp_max";

				return $this->select($query, $obj);
			}
		}

		function page_select(bonogaVO $obj, $mode, $where, $start_num, $sp_max){
			if($mode==1){
				$query = $this->bonoga_selectQuery;
				$query .= $where;

				return $this->count_select($query, $obj);
			}
			else if($mode==2){
				$query = $this->bonoga_selectQuery;
				$query .= $where;
				$query .= " ORDER BY iid DESC limit $start_num, $sp_max";

				return $this->select($query, $obj);
			}
		}

		function update_bonoga($obj, $mode){
			if($mode==1){
				return $this->update($this->bonoga_updateQuery, $obj);
			}
			else if($mode==2){
				return $this->update($this->announ_bonoga_updateQuery, $obj);
			}
			else if($mode==3){
				return $this->update($this->bonoga_gb_up_updateQuery, $obj);
			}
			else if($mode==4){
				return $this->update($this->bonoga_gb_down_updateQuery, $obj);
			}
		}

		function delete_bonoga($obj, $mode){
			if($mode==1){
				return $this->delete($this->bonoga_deleteQuery, $obj);
			}
			else if($mode==2){
				return $this->delete($this->announ_bonoga_deleteQuery, $obj);
			}
			else if($mode==3){
				return $this->delete($this->bonoga_gb_deleteQuery, $obj);
			}
		}

		function max_id($obj, $mode){
			if($mode==1){
				$res = $this->select($this->max_id_bonoga_selectQuery, $obj);

				$mid = $res[0]->{'MAX(iid)'};
			}
			else if($mode==2){
				$res = $this->select($this->max_bg_iid_selectQuery, $obj);

				$mid = $res[0]->{'MAX(bg_iid)'};
			}

			return $mid;
		}

		function alterAI($obj){
			$cnt = $this->count_select($this->announ_bonoga_selectQuery, $obj);

			return $this->alter($cnt+1, 3);
		}
	}
?>