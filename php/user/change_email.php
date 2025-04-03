<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.userVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$uid = $_GET['uid'];
		$new_email = $_POST["new_email"];
		$user_id = $_SESSION['user_id'];

		$uv = new userVO();
		$uv->user_id_email_con($user_id, $new_email);

		if ($uv->update(3)) {
			echo "<script>alert('이메일 수정 성공!');</script>";
			echo "<script>window.location.href='http://localhost/page/user/myaccount.htm?uid=".$uid."';</script>";
		} else {
			echo "<script>alert('이메일 수정 실패!');</script>";
			echo "<script>window.location.href='http://localhost/page/user/myaccount.htm?uid=".$uid."';</script>";
		}
	}
?>