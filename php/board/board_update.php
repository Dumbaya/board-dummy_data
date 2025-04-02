<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.boardVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$bid = $_GET['bid'];
		$tmp_num = $_POST['tmp_num'];
		$board_title = $_POST["board_title"];
		$board_body = $_POST["board_body"];

		$img_name = 'board_img';
		$dir_path = '../../img/board/';

		$bv = new boardVO();
		$bv->up_board_set($bid, $board_title, $board_body);

		$bv->img_set($img_name, $dir_path, 1);

		if ($bv->update(2)) {
			echo "<script>alert('게시글 수정 성공!');</script>";
			echo "<script>window.location.href='http://{도메인}/page/board/board_read.htm?bid=".$bid."';</script>";
		} else {
			echo "<script>alert('게시글 수정 실패!');</script>";
			echo "<script>window.history.back();</script>";
		}
}
?>