<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/DB.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.commonDAO.php');

	class diaryDAO extends commonDAO{
		private $diary_user_insertQuery = "
			INSERT INTO diary_user(did, d_writer, d_password) VALUES(
				:did,
				:d_writer,
				:d_password
			)
		";

		private $diary_list_insertQuery = "
			INSERT INTO diary_list(f_did, dl_title, dl_body, dl_date, dl_imgp) VALUES(
				:f_did,
				:dl_title,
				:dl_body,
				:dl_date,
				:dl_imgp
			)
		";

		private $diary_user_selectQuery = "
			SELECT * FROM diary_user WHERE d_writer=:d_writer
		";

		private $diary_list_selectQuery = "
			SELECT * FROM diary_list WHERE f_did=:f_did
		";

		private $diary_read_selectQuery = "
			SELECT * FROM diary_list WHERE dlid=:dlid;
		";

		private $diary_list_check_selectQuery = "
			SELECT b.dlid FROM diary_user a, diary_list b WHERE a.d_writer=:d_writer and a.did=b.f_did
		";

		private $diary_user_updateQuery = "
			UPDATE diary_user SET d_password=:d_password WHERE d_writer=:d_writer
		";

		private $diary_list_updateQuery = "
			UPDATE diary_list SET dl_title=:dl_title, dl_body=:dl_body, dl_imgp=:dl_imgp WHERE dlid=:dlid
		";

		private $diary_list_deleteQuery = "
			DELETE FROM diary_list WHERE dlid=:dlid
		";

		private $max_did_selectQuery = "
			SELECT MAX(did) FROM diary_user
		";

		private $max_dlid_selectQuery = "
			SELECT MAX(dlid) FROM diary_list
		";

		/*
		* mode
		* 1 == diary_user
		* 2 == diary_list
		*/
		function insert_diary($obj, $mode){
			if($mode==1){
				return $this->insert($this->diary_user_insertQuery, $obj);
			}
			else if($mode==2){
				return $this->insert($this->diary_list_insertQuery, $obj);
			}
		}

		/*
		* mode
		* 1 == diary_user 특정 유저 여부
		* 2 == diary_list
		* 1 == diary_user
		* 2 == diary_list
		* 1 == diary_user
		* 2 == diary_list
		*/
		function select_diary($obj, $mode, $start_num, $sp_max){
			if($mode==1){
				return $this->count_select($this->diary_user_selectQuery, $obj);
			}
			else if($mode==2){
				return $this->select($this->diary_user_selectQuery, $obj);
			}
			else if($mode==3){
				return $this->count_select($this->diary_list_selectQuery, $obj);
			}
			else if($mode==4){
				$query = $this->diary_list_selectQuery;
				$query .= " ORDER BY dlid DESC LIMIT $start_num, $sp_max";

				return $this->select($query, $obj);
			}
			else if($mode==5){
				return $this->select($this->diary_read_selectQuery, $obj);
			}
			else if($mode==6){
				return $this->count_select($this->diary_list_check_selectQuery, $obj);
			}
		}

		function where_select_diary($obj, $mode, $where, $start_num, $sp_max){
			if($mode==1){
				$query = $this->diary_list_selectQuery;
				$query .= $where;

				return $this->count_select($query, $obj);
			}
			else if($mode==2){
				$query = $this->diary_list_selectQuery;
				$query .= $where;
				$query .= " ORDER BY dlid DESC LIMIT $start_num, $sp_max";

				return $this->select($query, $obj);
			}
		}

		function update_diary($obj, $mode){
			if($mode==1){
				return $this->update($this->diary_user_updateQuery, $obj);
			}
			else if($mode==2){
				return $this->update($this->diary_list_updateQuery, $obj);
			}
		}

		function delete_diary($obj, $mode){
			if($mode==1){
				return $this->delete($this->diary_list_deleteQuery, $obj);
			}
		}

		function max_id($obj, $mode){
			if($mode==1){
				$res = $this->select($this->max_did_selectQuery, $obj);

				$mid = $res[0]->{'MAX(did)'};
			}

			else if($mode==2){
				$res = $this->select($this->max_dlid_selectQuery, $obj);

				$mid = $res[0]->{'MAX(dlid)'};
			}

			return $mid;
		}

		function alterAI($obj){
			$res = $this->select($this->max_dlid_selectQuery, $obj);

			$mid = $res[0]->{'MAX(dlid)'};

			return $this->alter($mid+1, 4);
		}
	}
?>