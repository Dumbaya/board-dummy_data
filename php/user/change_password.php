<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.userVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$user_id = $_SESSION['user_id'];
		$new_password = $_POST["new_password"];
		$uid = $_GET['uid'];

		$uv = new userVO();
		$uv->user_id_password_con($user_id, $new_password);

		if ($uv->update(1)) {
			echo "<script>alert('��й�ȣ ���� ����!');</script>";
			echo "<script>window.location.href='http://localhost/page/user/myaccount.htm?uid=".$uid."';</script>";
		} else {
			echo "<script>alert('��й�ȣ ���� ����!');</script>";
			echo "<script>window.location.href='http://localhost/page/user/myaccount.htm?uid=".$uid."';</script>";
		}
	}
?>