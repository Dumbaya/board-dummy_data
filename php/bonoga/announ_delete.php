<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.bonogaVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$aid = $_GET['aid'];

		//board 지우기
		$bv = new bonogaVO();

		$bv->setaid($aid);

		if ($bv->delete(2)) {
			echo "<script>alert('게시글 삭제 성공!');</script>";
			echo "<script>window.location.href='http://localhost/page/bonoga/gallery.htm?page=1';</script>";
		} else {
			echo "<script>alert('게시글 삭제 실패!');</script>";
			echo "<script>window.location.href='http://localhost/page/bonoga/announ_read.htm?aid=".$aid.";</script>";
		}
	}
?>