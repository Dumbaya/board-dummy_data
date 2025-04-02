<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/DB.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.commonDAO.php');

	class userDAO extends commonDAO{
		private $insertQuery = "
			INSERT INTO user(user_id, user_password, user_nickname, user_email) VALUES(
				:user_id,
				:user_password,
				:user_nickname,
				:user_email
			)
		";

		private $selectQuery = "
			SELECT * FROM user
		";
		private $user_nickname_selectQuery = "
			SELECT * FROM user WHERE user_nickname=:user_nickname
		";
		private $user_id_selectQuery = "
			SELECT * FROM user WHERE user_id=:user_id
		";
		private $user_email_selectQuery = "
			SELECT * FROM user WHERE user_email=:user_email
		";

		private $user_password_updateQuery = "
			UPDATE user SET user_password=:user_password WHERE user_id=:user_id
		";
		private $user_nickname_updateQuery = "
			UPDATE user SET user_nickname=:user_nickname WHERE user_id=:user_id
		";
		private $user_email_updateQuery = "
			UPDATE user SET user_email=:user_email WHERE user_id=:user_id
		";
		private $user_role_updateQuery = "
			UPDATE user SET user_role=:user_role WHERE user_id=:user_id
		";
		private $user_id_updateQuery = "
			UPDATE user SET user_id=:user_id WHERE uid=:uid
		";

		private $deleteQuery = "
			DELETE FROM user WHERE user_id=:user_id
		";

		function insertInfo($obj){//commonDAO로 보내기
			return $this->insert($this->insertQuery, $obj);
		}

		/*
		*mode
		* 1 == user_nickname 사용
		* 2 == user_id 사용
		* 3 == user_email 사용
		*/
		function selectListInfo(userVO $obj, $search=array(), $mode){
			if($mode==1){
				return $this->selectList($this->user_nickname_selectQuery, $obj, $search);
			}
			else if($mode==2){
				return $this->selectList($this->user_id_selectQuery, $obj, $search);
			}
			else if($mode==3){
				return $this->selectList($this->user_email_selectQuery, $obj, $search);
			}
		}

		/*
		*mode
		* 1 == user_password 업데이트
		* 2 == user_nickname 업데이트
		* 3 == user_email 업데이트
		* 4 == user_role 업데이트
		* 5 == user_id 업데이트
		*/
		function updateInfo($obj, $mode){
			if($mode==1){
				return $this->update($this->user_password_updateQuery, $obj);
			}
			if($mode==2){
				return $this->update($this->user_nickname_updateQuery, $obj);
			}
			if($mode==3){
				return $this->update($this->user_email_updateQuery, $obj);
			}
			if($mode==4){
				return $this->update($this->user_role_updateQuery, $obj);
			}
			if($mode==5){
				return $this->update($this->user_id_updateQuery, $obj);
			}
		}

		function alterAI($obj){//AutoIncrement 제어
			$cnt = $this->count_select($this->selectQuery, $obj);

			return $this->alter($cnt+1, 1);
		}

		function deleteInfo($obj){
			return $this->delete($this->deleteQuery, $obj);
		}
	}
?>