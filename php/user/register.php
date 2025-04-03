<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.userVO.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$user_id = $_POST["user_id"];
		$user_password = $_POST["user_password"];
		$user_nickname = $_POST["user_nickname"];
		$user_email = $_POST['user_email'];

		$uv = new userVo();
		$uv->reg_con($user_id, $user_password, $user_nickname, $user_email);
		if ($uv->insert()) {
			echo "<script>alert('회원가입 성공!');</script>";
			echo "<script>window.location.href='http://localhost/page/user/login.htm';</script>";
		} else {
			$uv->set_ai();
			echo "<script>alert('회원가입 실패!');</script>";
			echo "<script>window.location.href='http://localhost/page/user/register.htm';</script>";
		}
	}
?>