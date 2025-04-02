<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/DB.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.commonDAO.php');

	class adminDAO extends commonDAO{
		private $selectQuery = "
			SELECT * FROM user order by uid desc limit 10
		";
		private $cntselectQuery = "
			SELECT COUNT(uid) FROM user
		";
		private $f_userSearch_selectQuery = "
			SELECT * FROM user WHERE user_role=1
		";
		private $f_userInfo_selectQuery = "
			SELECT * FROM user WHERE uid=:uid
		";
		private $user_selectQuery = "
			SELECT * FROM user WHERE uid<=:last_uid ORDER BY uid DESC LIMIT 10
		";

		private $user_password_updateQuery = "
			UPDATE user SET user_password=:user_password WHERE uid=:uid
		";
		private $user_nickname_updateQuery = "
			UPDATE user SET user_nickname=:user_nickname WHERE uid=:uid
		";
		private $user_email_updateQuery = "
			UPDATE user SET user_email=:user_email WHERE uid=:uid
		";
		private $user_role_updateQuery = "
			UPDATE user SET user_role=:user_role WHERE uid=:uid
		";
		private $user_id_updateQuery = "
			UPDATE user SET user_id=:user_id WHERE uid=:uid
		";

		private $user_deleteQuery = "
			DELETE FROM user WHERE uid=:uid
		";

		/*
		* mode
		* 1 == 모든 유저 찾기
		* 2 == 유저 권한 1인 유저들 카운트
		* 3 == uid를 이용한 유저 찾기
		*/
		function selectUser(adminVO $obj, $mode, $start_num, $sp_max){
			if($mode==1){
				return $this->select($this->selectQuery, $obj);
			}
			else if($mode==2){
				return $this->count_select($this->f_userSearch_selectQuery, $obj);
			}
			else if($mode==3){
				return $this->select($this->f_userInfo_selectQuery, $obj);
			}
			else if($mode==4){
				return $this->select($this->cntselectQuery, $obj);
			}
			else if($mode==5){
				return $this->select($this->user_selectQuery, $obj);
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
		function updateUser(adminVO $obj, $mode){
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

		function deleteUser($obj){
			return $this->delete($this->user_deleteQuery, $obj);
		}
	}
?>