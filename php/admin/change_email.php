<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.adminVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$uid = $_GET['uid'];
		$new_email = $_POST["new_email"];

		$av = new adminVO();
		$av->setuid($uid);
		$av->setuser_email($new_email);

		if ($av->updateUser(3)) {
			echo "<script>alert('이메일 수정 성공!');</script>";
			echo "<script>window.location.href='http://localhost/page/admin/user_info.htm?uid=".$uid."';</script>";
		} else {
			echo "<script>alert('이메일 수정 실패!');</script>";
			echo "<script>window.location.href='http://localhost/page/admin/user_info.htm?uid=".$uid."';</script>";
		}
	}
?>