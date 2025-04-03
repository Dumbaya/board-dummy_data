<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.boardVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$f_bid = $_GET['bid'];
		$bc_comment = $_POST['board_comment'];
		$bc_writer = $_SESSION["user_nickname"];
		$bc_date = date("Y-m-d H:i:s");

		$tmp_num_mb = $_POST['tmp_num_mb'];

		$bv = new boardVO();

		$tmp_bcid = $bv->set_max_id(2);

		$group_id = $tmp_bcid;

		$bv->bc_set($f_bid, $tmp_bcid, $group_id, $bc_comment, $bc_writer, $bc_date);

		if ($bv->insert(3)) {
			echo "<script>alert('댓글 작성 성공!');</script>";
			echo "<script>window.location.href='http://localhost/page/board/board_read.htm?bid=".$f_bid."&tmp_num=".$tmp_num_mb."';</script>";
		} else {
			echo "<script>alert('댓글 작성 실패!');</script>";
			echo "<script>window.history.back();</script>";
		}
	}
?>