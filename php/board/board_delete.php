<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.boardVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$bid = $_GET['bid'];
		$tmp_num = $_POST['tmp_num'];

		//board �����
		$bv = new boardVO();
		$bv->setbid($bid);

		if ($bv->delete(2)) {
			switch($tmp_num){
				case 1:
					echo "<script>alert('�Խñ� ���� ����!');</script>";
					echo "<script>window.location.href='http://{������}/page/user/user_writeboard_about.htm';</script>";
					break;
				default:
					echo "<script>alert('�Խñ� ���� ����!');</script>";
					echo "<script>window.location.href='http://{������}/page/board/board.htm';</script>";
					break;
			}
		} else {
			echo "<script>alert('�Խñ� ���� ����!');</script>";
			echo "<script>window.history.back();</script>";
		}
	}
?>