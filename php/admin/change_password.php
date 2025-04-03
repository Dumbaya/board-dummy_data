<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/db.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$uid = $_GET['uid'];
		$new_password = $_POST["new_password"];

		$enc_password = base64_encode(openssl_encrypt($new_password, "AES-128-CBC", $secret_key, false));//비밀번호 암호화

		$sql = "update user set user_password=? where uid=?";
		$stmt = $con->prepare($sql);
		$stmt->bind_param('si',$enc_password, $uid);

		if ($stmt->execute()) {
			echo "<script>alert('비밀번호 수정 성공!');</script>";
			echo "<script>window.location.href='http://localhost/page/admin/user_info.htm?uid=".$uid."';</script>";
		} else {
			echo "<script>alert('비밀번호 수정 실패!');</script>";
			echo "<script>window.location.href='http://localhost/page/admin/user_info.htm?uid=".$uid."';</script>";
		}

		$stmt->close();
	}

	$con->close();
?>