<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.userVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$uid = $_GET['uid'];
		$user_id = $_SESSION['user_id'];

		$uv = new userVO();
		$uv->user_id_con($user_id);

		if ($uv->delete()) {
			session_destroy();
			echo "<script>alert('유저 삭제 성공!');</script>";
			echo "<script>window.location.href='http://{도메인}/page/homepage.htm';</script>";
		} else {
			echo "<script>alert('유저 삭제 실패!');</script>";
			echo "<script>window.history.back();</script>";
		}
	}
?>