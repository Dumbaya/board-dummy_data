<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/DB.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.commonDAO.php');

	class boardDAO extends commonDAO{
		private $board_cntselectQuery = "
			SELECT COUNT(bid) FROM board
		";
		private $board_selectQuery = "
			SELECT * FROM board order by bid desc limit 5
		";
		private $board_pure_selectQuery = "
			SELECT * FROM board
		";
		private $announ_board_selectQuery = "
			SELECT * FROM announ_board order by aid desc
		";
		private $board_comment_selectQuery = "
			SELECT * FROM board_comment WHERE f_bid=:f_bid
		";
		private $board_comment_cntselectQuery = "
			SELECT COUNT(bcid) FROM board_comment WHERE f_bid=:f_bid
		";
		private $board_writer_selectQuery = "
			SELECT * FROM board WHERE board_writer=:board_writer
		";
		private $board_writer_cntselectQuery = "
			SELECT COUNT(bid) FROM board WHERE board_writer=:board_writer
		";
		private $board_comment_writer_selectQuery = "
			SELECT * FROM board_comment WHERE bc_writer=:bc_writer
		";
		private $board_comment_writer_cntselectQuery = "
		SELECT COUNT(bcid) FROM board_comment WHERE bc_writer=:bc_writer
		";
		private $board_insertQuery = "
			INSERT INTO board(bid, board_title, board_writer, board_body, board_date, board_imgp) VALUES(
				:bid,
				:board_title,
				:board_writer,
				:board_body,
				:board_date,
				:board_imgp
			)
		";

		private $announ_board_insertQuery = "
			INSERT INTO announ_board(a_title, a_body, a_writer, a_date, a_imgp) VALUES(
				:a_title,
				:a_body,
				:a_writer,
				:a_date,
				:a_imgp
			)
		";

		private $board_comment_insertQuery = "
			INSERT INTO board_comment(f_bid, bcid, group_id, bc_comment, bc_writer, bc_date) VALUES(
				:f_bid,
				:bcid,
				:group_id,
				:bc_comment,
				:bc_writer,
				:bc_date
			)
		";

		private $mbid_selectQuery = "
			SELECT MAX(bid) FROM board
		";
		private $mbgbid_selectQuery = "
			SELECT MAX(bgbid) FROM board_gb
		";
		private $mbcid_selectQuery = "
			SELECT MAX(bcid) FROM board_comment
		";
		private $mbcgbid_selectQuery = "
			SELECT MAX(bcgbid) FROM board_comment_gb
		";

		private $f_announ_board_selectQuery = "
			SELECT * FROM announ_board where aid=:aid;
		";
		private $announ_board_updateQuery = "
			UPDATE announ_board SET a_title=:a_title, a_body=:a_body, a_imgp=:a_imgp WHERE aid=:aid
		";
		private $announ_board_deleteQuery = "
			DELETE FROM announ_board WHERE aid=:aid
		";

		private $f_board_selectQuery = "
			SELECT * FROM board where bid=:bid;
		";
		private $board_updateQuery = "
			UPDATE board SET board_title=:board_title, board_body=:board_body, board_imgp=:board_imgp WHERE bid=:bid
		";
		private $board_deleteQuery = "
			DELETE FROM board WHERE bid=:bid
		";

		private $board_View_updateQuery = "
			UPDATE board SET board_view=board_view+1 WHERE bid=:bid
		";

		private $bg_check_selectQuery = "
			SELECT * FROM board_gb WHERE f_bid=:f_bid and bg_user=:bg_user and bg_check=:bg_check
		";
		private $bg_insertQuery = "
			INSERT INTO board_gb(f_bid, bgbid, bg_user, bg_check) VALUES(
				:f_bid,
				:bgbid,
				:bg_user,
				:bg_check
			)
		";
		private $bg_up_updateQuery = "
			UPDATE board SET board_gb=board_gb+1 WHERE bid=:bid
		";
		private $bg_down_updateQuery = "
			UPDATE board SET board_gb=board_gb-1 WHERE bid=:bid
		";
		private $bg_good_deleteQuery = "
			DELETE FROM board_gb WHERE f_bid=:f_bid and bg_user=:bg_user and bg_check=:bg_check
		";

		private $comment_maxgroup_o_selectQuery = "
			SELECT MAX(group_o) FROM board_comment WHERE f_bid=:f_bid and pa_bcid=:pa_bcid and group_id=:group_id
		";
		private $comment_f_cnt_group_o_selectQuery = "
			SELECT group_o FROM board_comment WHERE f_bid=:f_bid and group_id=:group_id and group_o=:group_o
		";
		private $comment_group_o_updateQuery = "
			UPDATE board_comment SET group_o=group_o+1 WHERE f_bid=:f_bid and group_id=:group_id and group_o>=:group_o
		";
		private $set_newi = "
			SET @newi=:newi
		";
		private $comment_group_o_sort_updateQuery = "
			UPDATE board_comment SET group_o=(@newi:=@newi+1) WHERE f_bid=:f_bid and group_id=:group_id ORDER BY group_o asc
		";
		private $ccomment_insertQuery = "
			INSERT INTO board_comment(f_bid, bcid, pa_bcid, group_id, group_o, depth, bc_comment, bc_writer, bc_date) VALUES(
				:f_bid,
				:bcid,
				:pa_bcid,
				:group_id,
				:group_o,
				:depth,
				:bc_comment,
				:bc_writer,
				:bc_date
			)
		";
		private $bc_isdelete_updateQuery = "
			UPDATE board_comment SET is_delete=1 WHERE f_bid=:f_bid and bcid=:bcid
		";
		private $board_comment_updateQuery = "
			UPDATE board_comment SET bc_comment=:bc_comment WHERE bcid=:bcid
		";

		private $comment_gb_selectQuery = "
			SELECT * FROM board_comment_gb WHERE f_bid=:f_bid and f_bcid=:f_bcid and bcgb_user=:bcgb_user and bcgb_check=:bcgb_check
		";
		private $comment_gb_insertQuery = "
			INSERT INTO board_comment_gb(f_bid, f_bcid, bcgbid, bcgb_user, bcgb_check) VALUES(
				:f_bid,
				:f_bcid,
				:bcgbid,
				:bcgb_user,
				:bcgb_check
			)
		";
		private $comment_gb_up_updateQuery = "
			UPDATE board_comment SET bc_gb=bc_gb+1 WHERE bcid=:bcid
		";
		private $comment_gb_do_updateQuery = "
			UPDATE board_comment SET bc_gb=bc_gb-1 WHERE bcid=:bcid
		";
		private $comment_gb_deleteQuery = "
			DELETE FROM board_comment_gb WHERE f_bcid=:f_bcid and bcgb_user=:bcgb_user and bcgb_check=:bcgb_check
		";

		private $f_bid_selectQuery = "
			SELECT * FROM board_comment WHERE bcid=:bcid
		";
		private $board_read_selectQuery = "
			SELECT * FROM board WHERE bid<=:last_bid ORDER BY bid DESC LIMIT 5
		";

		private $bcc_selectQuery = "
			SELECT depth FROM board_comment WHERE bcid=:bcid
		";
		private $bcc_search_selectQuery = "
			SELECT group_o FROM board_comment WHERE bcid = :bcid
		";
		private $bcc_go_updateQuery = "
			UPDATE board_comment SET group_o = group_o + 1 WHERE group_id =:group_id AND group_o >= :group_o
		";
		private $bcc_search_lastgo_selectQuery = "
			SELECT bcid, group_o FROM board_comment WHERE group_id = :group_id AND pa_bcid = :pa_bcid ORDER BY group_o DESC LIMIT 1
		";

		/*
		* mode
		* 1 == board insert
		* 2 == announ_board insert
		* 3 == board_comment insert
		* 4 == board_gb insert
		* 5 == board_ccomment insert
		* 6 == board_comment gb insert
		*/
		function insert_board(boardVO $obj, $mode){
			if($mode==1){
				return $this->insert($this->board_insertQuery, $obj);
			}
			else if($mode==2){
				return $this->insert($this->announ_board_insertQuery, $obj);
			}
			else if($mode==3){
				return $this->insert($this->board_comment_insertQuery, $obj);
			}
			else if($mode==4){
				return $this->insert($this->bg_insertQuery, $obj);
			}
			else if($mode==5){
				return $this->insert($this->ccomment_insertQuery, $obj);
			}
			else if($mode==6){
				return $this->insert($this->comment_gb_insertQuery, $obj);
			}
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
		* 17 == board_comment 특정 값 group_o 카운트
		*/
		function select_board(boardVO $obj, $mode, $start_num, $sp_max){
			if($mode==1){
				return $this->select($this->board_selectQuery, $obj);
			}
			else if($mode==2){
				return $this->select($this->board_cntselectQuery, $obj);
			}
			else if($mode==3){
				return $this->select($this->announ_board_selectQuery, $obj);
			}
			else if($mode==4){
				return $this->count_select($this->announ_board_selectQuery, $obj);
			}
			else if($mode==5){
				$query = $this->board_selectQuery;
				$query .= " order by bid desc limit $start_num, $sp_max";
				return $this->select($query, $obj);
			}
			else if($mode==6){
				return $this->select($this->board_comment_cntselectQuery, $obj);
			}
			else if($mode==7){
				return $this->select($this->f_announ_board_selectQuery, $obj);
			}
			else if($mode==8){
				return $this->select($this->f_board_selectQuery, $obj);
			}
			else if($mode==9){
				return $this->select($this->board_writer_cntselectQuery, $obj);
			}
			else if($mode==10){
				return $this->select($this->board_writer_selectQuery, $obj);
			}
			else if($mode==11){
				return $this->select($this->board_comment_writer_cntselectQuery, $obj);
			}
			else if($mode==12){
				return $this->select($this->board_comment_writer_selectQuery, $obj);
			}
			else if($mode==13){
				$query = $this->board_writer_selectQuery;
				$query .= " order by bid desc limit $start_num, $sp_max";
				return $this->select($query, $obj);
			}
			else if($mode==14){
				$query = $this->board_comment_selectQuery;
				$query .= " order by group_id, group_o, pa_bcid desc, bc_date asc limit $start_num, $sp_max";
				return $this->select($query, $obj);
			}
			else if($mode==15){
				return $this->select($this->bcc_selectQuery, $obj);
			}
			else if($mode==16){
				return $this->select($this->comment_maxgroup_o_selectQuery, $obj);
			}
			else if($mode==17){
				return $this->count_select($this->comment_f_cnt_group_o_selectQuery, $obj);
			}
			else if($mode==18){
				$query = $this->board_comment_writer_selectQuery;
				$query .= " order by bcid desc limit $start_num, $sp_max";
				return $this->select($query, $obj);
			}
			else if($mode==19){
				return $this->select($this->f_bid_selectQuery, $obj);
			}
			else if($mode==20){
				return $this->select($this->board_read_selectQuery, $obj);
			}
			else if($mode==21){
				return $this->select($this->bcc_search_selectQuery, $obj);
			}
			else if($mode==22){
				return $this->select($this->bcc_search_lastgo_selectQuery, $obj);
			}
		}

		/*
		* mode
		* 1 == board search 데이터 카운트
		* 2 == board search 데이터 가져오기
		*/
		function search_select_board(boardVO $obj, $mode, $where, $start_num, $sp_max){
			if($mode==1){
				$query = $this->board_cntselectQuery;
				$query .= $where;
				return $this->select($query, $obj);
			}
			else if($mode==2){
				$query = $this->board_pure_selectQuery;
				$query .= $where;
				$query .= " order by bid desc limit $start_num, $sp_max";
				return $this->select($query, $obj);
			}
			else if($mode==3){
				$query = $this->board_writer_cntselectQuery;
				$query .= $where;
				return $this->select($query, $obj);
			}
			else if($mode==4){
				$query = $this->board_writer_selectQuery;
				$query .= $where;
				$query .= " order by bid desc limit $start_num, $sp_max";
				return $this->select($query, $obj);
			}
			else if($mode==5){
				$query = $this->board_comment_writer_cntselectQuery;
				$query .= $where;
				return $this->select($query, $obj);
			}
			else if($mode==6){
				$query = $this->board_comment_writer_selectQuery;
				$query .= $where;
				$query .= " order by bcid desc limit $start_num, $sp_max";
				return $this->select($query, $obj);
			}
		}

		/*
		* mode
		* 1 == board_gb
		* 2 == board_comment_gb
		*/
		function bg_check_select($obj, $mode){
			if($mode==1){
				return $this->count_select($this->bg_check_selectQuery, $obj);
			}
			else if($mode==2){
				return $this->count_select($this->comment_gb_selectQuery, $obj);
			}
		}

		/*
		* mode
		* 1 == announ board 업데이트
		* 2 == board 업데이트
		* 3 == board_view 업데이트
		* 4 == board_gb up 업데이트
		* 5 == board_gb down 업데이트
		* 6 == board_comment group_o 업데이트
		* 7 == board_comment group_o 정렬 업데이트
		* 8 == board_comment is_delete 업데이트
		* 9 == board_comment 업데이트
		* 10 == board_comment_gb up 업데이트
		* 11 == board_comment_gb down 업데이트
		*/
		function update_board($obj, $mode){
			if($mode==1){
				return $this->update($this->announ_board_updateQuery, $obj);
			}
			else if($mode==2){
				return $this->update($this->board_updateQuery, $obj);
			}
			else if($mode==3){
				return $this->update($this->board_View_updateQuery, $obj);
			}
			else if($mode==4){
				return $this->update($this->bg_up_updateQuery, $obj);
			}
			else if($mode==5){
				return $this->update($this->bg_down_updateQuery, $obj);
			}
			else if($mode==6){
				return $this->update($this->comment_group_o_updateQuery, $obj);
			}
			else if($mode==7){
				
				$this->nob_dml($this->set_newi);
				return $this->update($this->comment_group_o_sort_updateQuery, $obj);
			}
			else if($mode==8){
				return $this->update($this->bc_isdelete_updateQuery, $obj);
			}
			else if($mode==9){
				return $this->update($this->board_comment_updateQuery, $obj);
			}
			else if($mode==10){
				return $this->update($this->comment_gb_up_updateQuery, $obj);
			}
			else if($mode==11){
				return $this->update($this->comment_gb_do_updateQuery, $obj);
			}
			else if($mode==12){
				return $this->update($this->bcc_go_updateQuery, $obj);
			}
		}

		/*
		* mode
		* 1 == announ board 삭제
		* 2 == board 삭제
		* 3 == board_gb 삭제
		* 4 == board_comment_gb 삭제
		*/
		function delete_board($obj, $mode){
			if($mode==1){
				return $this->delete($this->announ_board_deleteQuery, $obj);
			}
			else if($mode==2){
				return $this->delete($this->board_deleteQuery, $obj);
			}
			else if($mode==3){
				return $this->delete($this->bg_good_deleteQuery, $obj);
			}
			else if($mode==4){
				return $this->delete($this->comment_gb_deleteQuery, $obj);
			}
		}

		/*
		* mode
		* 1 == board bid 값 만들기
		* 2 == board_comment
		* 3 == board_gb
		* 4 == board_comment_gb
		*/
		function setid($obj, $mode){
			if($mode==1){
				$row = $this->select($this->mbid_selectQuery, $obj);
				$mid = $row[0]->{'MAX(bid)'};
			}
			else if($mode==2){
				$row = $this->select($this->mbcid_selectQuery, $obj);
				$mid = $row[0]->{'MAX(bcid)'};
			}
			else if($mode==3){
				$row = $this->select($this->mbgbid_selectQuery, $obj);
				$mid = $row[0]->{'MAX(bgbid)'};
			}
			else if($mode==4){
				$row = $this->select($this->mbcgbid_selectQuery, $obj);
				$mid = $row[0]->{'MAX(bcgbid)'};
			}

			return $mid;
		}

		function alterAI($obj){
			$cnt = $this->count_select($this->announ_board_selectQuery, $obj);

			return $this->alter($cnt+1, 2);
		}
	}
?>