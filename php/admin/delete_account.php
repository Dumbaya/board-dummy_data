<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.adminVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$uid = $_GET['uid'];
		
		$av = new adminVO();
		$av->setuid($uid);
		$row = $av->selectUser(3);
		$adminVO = $row[0];

		if ($av->deleteUser()) {
			echo "<script>alert('유저 삭제 성공!');</script>";
			echo "<script>window.location.href='http://{도메인}/page/admin/user_account_info.htm';</script>";
		} else {
			echo "<script>alert('유저 삭제 실패!');</script>";
			echo "<script>window.location.href='http://{도메인}/page/admin/user_info.htm?uid=".$uid."';</script>";
		}
	}
?>