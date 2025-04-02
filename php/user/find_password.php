<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.userVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$user_id = $_POST['fp_id'];
		$new_password = $_POST["new_password"];

		$uv = new userVO();
		$uv->user_id_password_con($user_id, $new_password);

		if ($uv->update(1)) {
			echo "<script>alert('새 비밀번호 설정 성공!');</script>";
			echo "<script>window.location.href='http://{도메인}/page/user/login.htm';</script>";
		} else {
			echo "<script>alert('새 비밀번호 설정 실패!');</script>";
			echo "<script>window.history.back();</script>";
		}
	}
?>