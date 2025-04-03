<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.adminVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$uid = $_GET['uid'];
		$new_nickname = $_POST["new_nickname"];

		$av = new adminVO();
		$av->setuid($uid);
		$av->setuser_nickname($new_nickname);

		if ($av->updateUser(2)) {
			$_SESSION['user_nickname'] = $new_nickname;
			echo "<script>alert('닉네임 수정 성공!');</script>";
			echo "<script>window.location.href='http://localhost/page/admin/user_info.htm?uid=".$uid."';</script>";
		} else {
			echo "<script>alert('닉네임 수정 실패!');</script>";
			echo "<script>window.location.href='http://localhost/page/admin/user_info.htm?uid=".$uid."';</script>";
		}
	}
?>