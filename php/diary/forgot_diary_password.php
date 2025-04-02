<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.diaryVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$user_nickname = $_SESSION['user_nickname'];
		$new_password = $_POST["new_password"];

		$dv = new diaryVO();
		$com = new common();

		$enc_password = $com->sha256_encode($new_password);//비밀번호 암호화

		$dv->setd_writer($user_nickname);
		$dv->setd_password($enc_password);

		if ($dv->update(1)) {
			echo "<script>alert('새 비밀번호 설정 성공!');</script>";
			echo "<script>window.location.href='http://{도메인}/page/diary/for_diary_password.htm';</script>";
		} else {
			echo "<script>alert('새 비밀번호 설정 실패!');</script>";
			echo "<script>window.history.back();</script>";
		}
	}
?>