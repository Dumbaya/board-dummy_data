<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.diaryVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$d_writer = $_SESSION['user_nickname'];
		$d_password = $_POST['for_diaryp'];

		$dv = new diaryVO();

		$dv->diary_user_set($d_writer, $d_password);

		if ($dv->insert(1)) {
			echo "<script>alert('비밀번호 입력 성공!');</script>";
			echo "<script>window.location.href='http://localhost/page/diary/diary_list.htm';</script>";
		} else {
			echo "<script>alert('비밀번호 입력 실패!');</script>";
			echo "<script>window.location.href='http://localhost/page/diary/for_diary_password.htm';</script>";
		}
	}
?>