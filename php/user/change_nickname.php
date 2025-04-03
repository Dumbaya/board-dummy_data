<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/db.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$uid = $_GET['uid'];
		$new_nickname = $_POST["new_nickname"];

		$cov_nn = iconv('EUC-KR', 'UTF-8', $new_nickname);

		$sql = "update user set user_nickname=? where uid=?";
		$stmt = $con->prepare($sql);
		$stmt->bind_param('si',$cov_nn, $uid);

		if ($stmt->execute()) {
			$_SESSION['user_nickname'] = $cov_nn;
			echo "<script>alert('닉네임 수정 성공!');</script>";
			echo "<script>window.location.href='http://localhost/page/user/myaccount.htm?uid=".$uid."';</script>";
		} else {
			echo "<script>alert('닉네임 수정 실패!');</script>";
			echo "<script>window.location.href='http://localhost/page/user/myaccount.htm?uid=".$uid."';</script>";
		}

		$stmt->close();
	}

	$con->close();
?>