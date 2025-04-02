<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.boardVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$bid = $_GET['bid'];
		$tmp_num = $_POST['tmp_num'];

		//board 지우기
		$bv = new boardVO();
		$bv->setbid($bid);

		if ($bv->delete(2)) {
			switch($tmp_num){
				case 1:
					echo "<script>alert('게시글 삭제 성공!');</script>";
					echo "<script>window.location.href='http://{도메인}/page/user/user_writeboard_about.htm';</script>";
					break;
				default:
					echo "<script>alert('게시글 삭제 성공!');</script>";
					echo "<script>window.location.href='http://{도메인}/page/board/board.htm';</script>";
					break;
			}
		} else {
			echo "<script>alert('게시글 삭제 실패!');</script>";
			echo "<script>window.history.back();</script>";
		}
	}
?>