<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.adminVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$uid = $_GET['uid'];
		$new_id = $_POST["new_id"];

		$av = new adminVO();
		$av->setuid($uid);
		$av->setuser_id($new_id);

		if ($av->updateUser(5)) {
			$_SESSION['user_id'] = $new_id;
			echo "<script>alert('���̵� ���� ����!');</script>";
			echo "<script>window.location.href='http://{������}/page/admin/user_info.htm?uid=".$uid."';</script>";
		} else {
			echo "<script>alert('���̵� ���� ����!');</script>";
			echo "<script>window.location.href='http://{������}/page/admin/user_info.htm?uid=".$uid."';</script>";
		}
	}
?>