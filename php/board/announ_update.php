<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.boardVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$aid = $_GET['aid'];
		$a_title = $_POST["announ_title"];
		$a_body = $_POST["announ_body"];

		$img_name = 'aboard_img';
		$dir_path = '../../img/aboard/';

		$bv = new boardVO();
		$bv->up_announ_set($aid, $a_title, $a_body);

		$bv->img_set($img_name, $dir_path, 2);

		if ($bv->update(1)) {
			echo "<script>alert('공지 수정 성공!');</script>";
			echo "<script>window.location.href='http://{도메인}/page/board/announ_read.htm?aid=".$aid."';</script>";
		} else {
			echo "<script>alert('공지 수정 실패!');</script>";
			echo "<script>window.history.back();</script>";
		}
	}
?>