<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.boardVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$f_bcid = $_GET['bcid'];
		$tmp_num_mb = $_POST['tmp_num_mb'];
		$f_bid = $_POST['bc_for_bad'];
		$bcgb_user = $_SESSION["user_nickname"];
		$bcgb_check=1;

		if(isset($bcgb_user)==false){
			echo "<script>alert('로그인 후 이용해주세요');</script>";
			echo "<script>window.location.href='http://localhost/page/user/login.htm?tmp_num=2&bid=".$f_bid."&tmp_num_mb=".$tmp_num_mb."';</script>";
		}

		$bv = new boardVO();

		//실패했을 때도 bgbid값이 증가하기 때문에 이를 맞추기 위함
		$bcgbid = $bv->set_max_id(4);

		$bv->bcgb_set($f_bid, $f_bcid, $bcgbid, $bcgb_user, $bcgb_check);

		//해당 게시글에 대해 추천을 했는지 확인용
		$cnt_row = $bv->check_select(2);
		
		if($cnt_row==0){
			if ($bv->insert(6) && $bv->update(11)) {
				echo "<script>alert('댓글 비추천 성공!');</script>";
				echo "<script>window.location.href='http://localhost/page/board/board_read.htm?page=1&bid=".$f_bid."&tmp_num=".$tmp_num_mb."';</script>";
			} else {
				echo "<script>alert('댓글 비추천 실패!');</script>";
				echo "<script>window.history.back();</script>";
			}
		}
		else if($cnt_row==1){
			if ($bv->delete(4) && $bv->update(10)) {
				echo "<script>alert('댓글 비추천 취소 성공!');</script>";
				echo "<script>window.location.href='http://localhost/page/board/board_read.htm?page=1&bid=".$f_bid."&tmp_num=".$tmp_num_mb."';</script>";
			} else {
				echo "<script>alert('댓글 비추천 취소 실패!');</script>";
				echo "<script>window.history.back();</script>";
			}
		}
	}
?>