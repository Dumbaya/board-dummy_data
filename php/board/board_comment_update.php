<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.boardVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$bcid = $_GET['bcid'];
		$tmp_num = $_POST['tmp_num'];
		$bc_comment = $_POST["bc_comment"];
		$bid = $_POST['bid'];

		$bv = new boardVO();
		$bv->bc_upd_set($bcid, $bc_comment);

		if ($bv->update(9)) {
			echo "<script>alert('댓글 수정 성공!');</script>";
			//echo "<script>window.location.href='http://localhost/page/board/board_read.htm?bid=".$bid."';</script>";
			echo "<script>opener.location.reload();</script>";
			echo "<script>self.close();</script>";
		} else {
			echo "<script>alert('댓글 수정 성공!');</script>";
			echo "<script>window.history.back();</script>";
		}
	}
?>