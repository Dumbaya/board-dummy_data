<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.boardVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$aid = $_GET['aid'];

		//board �����
		$bv = new boardVO();

		$bv->setaid($aid);

		if ($bv->delete(1)) {
			echo "<script>alert('�Խñ� ���� ����!');</script>";
			echo "<script>window.location.href='http://localhost/page/board/board.htm?page=1';</script>";
		} else {
			echo "<script>alert('�Խñ� ���� ����!');</script>";
			echo "<script>window.history.back();</script>";
		}
	}
?>