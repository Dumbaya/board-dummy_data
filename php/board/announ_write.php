<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.boardVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$announ_title = $_POST["announ_title"];
		$announ_writer = $_SESSION['user_nickname'];
		$announ_body = $_POST["announ_body"];
		$announ_date = date("Y-m-d H:i:s");

		$img_name = 'aboard_img';
		$dir_path = '../../img/aboard/';

		$bv = new boardVO();
		$bv->announ_set($announ_title, $announ_body, $announ_writer, $announ_date);
		$bv->img_set($img_name, $dir_path, 2);

		if ($bv->insert(2)) {
			echo "<script>alert('공지 등록 성공!');</script>";
			echo "<script>window.location.href='http://localhost/page/board/board.htm?page=1';</script>";
		} else {
			$bv->set_ai();
			echo "<script>alert('공지 등록 실패!');</script>";
			echo "<script>window.location.href='http://localhost/page/board/announ_write.htm';</script>";
		}
	}
?>