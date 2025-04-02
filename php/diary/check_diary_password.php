<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.diaryVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$d_writer = $_SESSION['user_nickname'];
		$d_password = $_POST['for_diaryp'];

		$dv = new diaryVO();
		$com = new common();

		$enc_password = $com->sha256_encode($d_password);

		$dv->setd_writer($d_writer);

		$cnt = $dv->select(1);
		$row = $dv->select(2);
		$dr = $row[0];

		if ($cnt > 0) {
			if (strcmp($enc_password, $dr->d_password)==0) {
				echo "<script>alert('인증 성공!'); window.location.href = 'http://{도메인}/page/diary/diary_list.htm?did=".$dr->did."';</script>";
			} else {
				echo "<script>alert('잘못된 비밀번호입니다.'); window.history.back();</script>";
			}
		} else {
			echo "<script>alert('존재하지 않는 사용자입니다.'); window.history.back();</script>";
		}
	}
?>