<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/DB.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.commonDAO.php');

	class dummyDAO extends commonDAO{
		private $muid_selectQuery = "
			SELECT MAX(uid) FROM user
		";
		private $mbid_selectQuery = "
			SELECT MAX(bid) FROM board
		";
		private $mbcid_selectQuery = "
			SELECT MAX(bcid) FROM board_comment
		";

		private $is_procedure = "
			DROP PROCEDURE IF EXISTS insertDummy
		";

		private $dummy_procedure_user_setQuery = "
			CREATE PROCEDURE insertDummy(
				IN start_num INT,
				IN count_p INT,
				IN user_password_p VARCHAR(128)
			)
			BEGIN
				DECLARE i INT DEFAULT start_num;
				DECLARE max_size INT DEFAULT 100000;
				DECLARE chk_cnt INT DEFAULT 0;
				
				while i<=count_p do
					IF chk_cnt = 0 THEN
						START TRANSACTION;
					END IF;

					INSERT INTO `user` (user_id, user_password, user_nickname, user_email, is_dummy)
					VALUES (CONCAT('test_dummy', i), user_password_p, CONCAT('test_dummy', i), CONCAT('test_dummy', i), 1);
					SET i = i + 1;
					SET chk_cnt = chk_cnt+1;

					IF chk_cnt = max_size THEN
						COMMIT;
						SET chk_cnt = 0;
					END IF;
				END while;
				
				IF chk_cnt > 0 THEN
					COMMIT;
				END IF;
			END;
		";
		private $call_dummy_procedure_userQuery = "
			CALL insertDummy(:start_num, :count, :user_password);
		";

		private $dummy_procedure_board_setQuery = "
			CREATE PROCEDURE insertDummy(
				IN start_num INT,
				IN count_p INT
			)
			BEGIN
				DECLARE i INT DEFAULT start_num;
				DECLARE max_size INT DEFAULT 100000;
				DECLARE chk_cnt INT DEFAULT 0;
				
				while i<=count_p do
					IF chk_cnt = 0 THEN
						START TRANSACTION;
					END IF;

					INSERT INTO `board` (bid, board_title, board_writer, board_body, board_date, board_imgp, is_dummy)
					VALUES (i, CONCAT('test_dummy', i), 'dummy_writer', CONCAT('test_dummy', i), now(), '../../img/board/test.jpg', 1);
					SET i = i + 1;
					SET chk_cnt = chk_cnt+1;

					IF chk_cnt = max_size THEN
						COMMIT;
						SET chk_cnt = 0;
					END IF;
				END while;
				
				IF chk_cnt > 0 THEN
					COMMIT;
					SET chk_cnt = 0;
				END IF;
			END;
		";
		private $call_dummy_procedure_boardQuery = "
			CALL insertDummy(:start_num, :count);
		";

		private $dummy_procedure_board_comment_setQuery = "
			CREATE PROCEDURE insertDummy(
				IN start_num INT,
				IN count_p INT,
				IN board_count INT,
				IN t_bcid INT
			)
			BEGIN
				DECLARE i INT DEFAULT start_num;
				DECLARE max_size INT DEFAULT 100000;
				DECLARE chk_cnt INT DEFAULT 0;
				DECLARE ran_fbid INT;
				DECLARE ran_pabcid INT;
				DECLARE ran_groupid INT;
				DECLARE ran_groupo INT;
				DECLARE ran_depth INT;
				DECLARE chk_bc INT;
				DECLARE chk_go INT;
				DECLARE up_chk_go INT;

				while i<=count_p do
					IF chk_cnt = 0 THEN
						START TRANSACTION;
					END IF;

					SELECT FLOOR(1+(RAND()*board_count)) INTO ran_fbid;
					SELECT COUNT(bcid) FROM board_comment WHERE f_bid=ran_fbid INTO chk_bc;

					IF chk_bc=0 THEN
						SET ran_pabcid=0;
						SET ran_groupid=t_bcid+1;
						SET ran_groupo=0;
						SET ran_depth=0;
					ELSE
						SELECT bcid FROM board_comment WHERE f_bid=ran_fbid ORDER BY RAND() LIMIT 1 INTO ran_pabcid;
						SELECT group_id, group_o, depth FROM board_comment WHERE bcid = ran_pabcid INTO ran_groupid, ran_groupo, ran_depth;
						SELECT MAX(group_o) FROM board_comment WHERE pa_bcid=ran_pabcid INTO chk_go;
						SELECT MAX(group_o) FROM board_comment WHERE f_bid=ran_fbid AND group_id=ran_groupid INTO up_chk_go;

						IF chk_go IS NULL THEN
							SET ran_groupo=ran_groupo+1;
						ELSE
							CALL findlg(ran_groupid, ran_pabcid, ran_groupo);
						END IF;

						SET ran_depth = ran_depth+1;

						IF ran_groupo<=up_chk_go THEN
							UPDATE board_comment SET group_o = group_o + 1 WHERE group_id = ran_groupid AND group_o >= ran_groupo;
						END IF;
					END IF;

					INSERT INTO `board_comment` (f_bid, bcid, pa_bcid, group_id, group_o, depth, bc_comment, bc_writer, bc_date, is_dummy)
					VALUES (ran_fbid, t_bcid+1, ran_pabcid, ran_groupid, ran_groupo, ran_depth, CONCAT('test_dummy', i), 'dummy_writer', now(), 1);
					SET i = i + 1;
					SET t_bcid = t_bcid+1;
					SET chk_cnt = chk_cnt+1;

					IF chk_cnt = max_size THEN
						COMMIT;
						SET chk_cnt = 0;
					END IF;
				END while;
				
				IF chk_cnt > 0 THEN
					COMMIT;
					SET chk_cnt = 0;
				END IF;
			END;
		";
		private $call_dummy_procedure_board_commentQuery = "
			CALL insertDummy(:start_num, :count, :board_count, :bcid);
		";

		private $c_user_selectQuery = "
			SELECT * FROM user WHERE is_dummy=1
		";
		private $dummy_user_deleteQuery = "
			DELETE FROM user WHERE is_dummy=1 LIMIT 1000000
		";

		private $c_board_selectQuery = "
			SELECT * FROM board WHERE is_dummy=1
		";
		private $dummy_board_deleteQuery = "
			DELETE FROM board WHERE is_dummy=1 LIMIT 1000000
		";

		private $c_board_comment_selectQuery = "
			SELECT * FROM board_comment WHERE is_dummy=1
		";
		private $dummy_board_comment_deleteQuery = "
			DELETE FROM board_comment WHERE is_dummy=1 LIMIT 1000000
		";

		private $user_selectQuery = "
			SELECT * FROM user
		";
		private $user_cntselectQuery = "
			SELECT COUNT(uid) FROM user
		";
		private $board_selectQuery = "
			SELECT * FROM board
		";
		private $board_cntselectQuery = "
			SELECT COUNT(bid) FROM board
		";
		private $board_comment_selectQuery = "
			SELECT * FROM board_comment
		";
		private $board_comment_cntselectQuery = "
			SELECT COUNT(bcid) FROM board_comment
		";

		private $last_dummy_user_selectQuery = "
			SELECT * FROM user WHERE user_id LIKE 'test_dummy%' ORDER BY uid DESC LIMIT 1
		";
		private $last_dummy_board_selectQuery = "
			SELECT * FROM board WHERE board_title LIKE 'test_dummy%' ORDER BY bid DESC LIMIT 1
		";
		private $last_dummy_board_comment_selectQuery = "
			SELECT * FROM board_comment WHERE bc_comment LIKE 'test_dummy%' ORDER BY bcid DESC LIMIT 1
		";

		private $dummy_procedure_board_setdQuery = "
			CREATE PROCEDURE deleteDummy(
				IN start_num INT,
				IN count_p INT,
				IN bid INT
			)
			BEGIN
				DECLARE i INT DEFAULT start_num;
				DECLARE max_size INT DEFAULT 100000;
				DECLARE chk_cnt INT DEFAULT 0;
				
				while i<=count_p do
					IF chk_cnt = 0 THEN
						START TRANSACTION;
					END IF;

					DELETE FROM `board` WHERE is_dummy=1

					IF chk_cnt = max_size THEN
						COMMIT;
						SET chk_cnt = 0;
					END IF;
				END while;
				
				IF chk_cnt > 0 THEN
					COMMIT;
					SET chk_cnt = 0;
				END IF;
			END;
		";
		private $call_dummy_procedure_boarddQuery = "
			CALL insertDummy(:start_num, :count, :bid);
		";
		private $cash_del_user1 = "
			ALTER TABLE user SHRINK SPACE
		";
		private $cash_del_user2 = "
			ALTER TABLE user DEALLOCATE UNUSED
		";
		private $cash_del_board1 = "
			ALTER TABLE board SHRINK SPACE
		";
		private $cash_del_board2 = "
			ALTER TABLE board DEALLOCATE UNUSED
		";
		private $cash_del_board_comment1 = "
			ALTER TABLE board_comment SHRINK SPACE
		";
		private $cash_del_board_comment2 = "
			ALTER TABLE board_comment DEALLOCATE UNUSED
		";
		private $optimize_user = "
			OPTIMIZE TABLE user;
		";
		private $optimize_board = "
			OPTIMIZE TABLE board;
		";
		private $optimize_board_comment = "
			OPTIMIZE TABLE board_comment;
		";
		/*
		* mode
		* 1 == user
		* 2 == board
		* 3 == board_comment
		*/
		function insert_dummy($obj, $mode){
			
			$this->nob_dml($this->is_procedure);
			if($mode==1){
				$this->nob_dml($this->dummy_procedure_user_setQuery);
				return $this->dml($this->call_dummy_procedure_userQuery, $obj);
			}
			else if($mode==2){
				$this->nob_dml($this->dummy_procedure_board_setQuery);
				return $this->dml($this->call_dummy_procedure_boardQuery, $obj);
			}
			else if($mode==3){
				$this->nob_dml($this->dummy_procedure_board_comment_setQuery);
				return $this->dml($this->call_dummy_procedure_board_commentQuery, $obj);
			}
		}

		/*
		* mode
		* 1 == user
		* 2 == board
		* 3 == board_comment
		*/
		function delete_dummy($obj, $mode){
			if($mode==1){
				return $this->nob_dml($this->dummy_user_deleteQuery);
			}
			if($mode==2){
				return $this->nob_dml($this->dummy_board_deleteQuery);
			}
			if($mode==3){
				return $this->nob_dml($this->dummy_board_comment_deleteQuery);
			}
		}

		function count($obj, $mode){
			if($mode==1){
				$tmp_row = $this->select($this->user_cntselectQuery, $obj);
				return $tmp_row[0]->{'COUNT(uid)'};
			}
			else if($mode==2){
				$tmp_row = $this->select($this->board_cntselectQuery, $obj);
				return $tmp_row[0]->{'COUNT(bid)'};
			}
			else if($mode==3){
				$tmp_row = $this->select($this->board_comment_cntselectQuery, $obj);
				return $tmp_row[0]->{'COUNT(bcid)'};
			}
		}
		function f_del_dum($obj, $mode){
			if($mode==1){
				return $this->count_select($this->c_user_selectQuery, $obj);
			}
			if($mode==2){
				return $this->count_select($this->c_board_selectQuery, $obj);
			}
			if($mode==3){
				return $this->count_select($this->c_board_comment_selectQuery, $obj);
			}
		}

		/*
		* mode
		* 1 == user
		* 2 == board
		* 3 == board_comment
		*/
		function setid($obj, $mode){
			if($mode==1){
				$row = $this->select($this->muid_selectQuery, $obj);
				$mid = $row[0]->{'MAX(uid)'};
			}
			else if($mode==2){
				$row = $this->select($this->mbid_selectQuery, $obj);
				$mid = $row[0]->{'MAX(bid)'};
			}
			else if($mode==3){
				$row = $this->select($this->mbcid_selectQuery, $obj);
				$mid = $row[0]->{'MAX(bcid)'};
			}
			echo $mid."\n";
			if($mid==''){
				$mid=0;
			}
			return $mid;
		}

		function alterAI($obj, $mode){//AutoIncrement 제어
			if($mode==1){
				$cnt = $this->count_select($this->user_selectQuery, $obj);
			}
			return $this->alter($cnt+1, 1);
		}

		function alter_cash($obj, $mode){
			if($mode==1){
				$this->alter($this->cash_del_user1);
				return $this->alter($this->cash_del_user2);
			}
			else if($mode==2){
				$this->alter($this->cash_del_board1);
				return $this->alter($this->cash_del_board2);
			}
			else if($mode==3){
				$this->alter($this->cash_del_board_comment1);
				return $this->alter($this->cash_del_board_comment2);
			}
		}

		/*
		* mode
		* 1 == user
		* 2 == board
		* 3 == board_comment
		*/
		function for_last_cnt($obj, $mode){
			if($mode==1){
				$row = $this->select($this->last_dummy_user_selectQuery, $obj);
				$lc = $row[0]->{'user_id'};
			}
			else if($mode==2){
				$row = $this->select($this->last_dummy_board_selectQuery, $obj);
				$lc = $row[0]->{'board_title'};
			}
			else if($mode==3){
				$row = $this->select($this->last_dummy_board_comment_selectQuery, $obj);
				$lc = $row[0]->{'bc_comment'};
			}
			echo $lc."\n";
			return $lc;
		}

		function optimize_table($mode){
			if($mode==1){
				return $this->nob_dml($this->optimize_user);
			}
			else if($mode==2){
				return $this->nob_dml($this->optimize_board);
			}
			else if($mode==2){
				return $this->nob_dml($this->optimize_board_comment);
			}
		}
	}
?>