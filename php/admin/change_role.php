<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.adminVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$uid = $_GET['uid'];
		$new_role = $_POST["new_role"];

		$av = new adminVO();
		$av->setuid($uid);
		$av->setuser_role($new_role);

		if ($av->updateUser(4)) {
			$_SESSION['user_role'] = $new_role;
			echo "<script>alert('권한 수정 성공!');</script>";
			echo "<script>window.location.href='http://localhost/page/admin/user_info.htm?uid=".$uid."';</script>";
		} else {
			echo "<script>alert('권한 수정 실패!');</script>";
			echo "<script>window.location.href='http://localhost/page/admin/user_info.htm?uid=".$uid."';</script>";
		}
	}
?>