<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.boardVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$bid = $_GET['bid'];
		$tmp_num_mb = $_POST['tmp_num_mb'];
		$bcid = $_POST['bcid'];
		$tmp_num = $_POST['tmp_num'];

		//board_comment �����
		$bv = new boardVO();
		
		$bv->setf_bid($bid);
		$bv->setbcid($bcid);

		if ($bv->update(8)) {
			switch($tmp_num){
				case 1:
					echo "<script>alert('��� ���� ����!');</script>";
					echo "<script>window.location.href='http://{������}/page/user/user_writebc_about.htm';</script>";
					break;
				case 2:
					echo "<script>alert('��� ���� ����!');</script>";
					echo "<script>window.location.href='http://{������}/page/board/board_read.htm?page=1&bid=".$bid."&tmp_num=".$tmp_num_mb."';</script>";
					break;
			}
			
		} else {
			echo "<script>alert('��� ���� ����!');</script>";
			echo "<script>window.history.back();</script>";
		}
	}

	$con->close();
?>