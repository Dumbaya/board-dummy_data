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
				echo "<script>alert('���� ����!'); window.location.href = 'http://{������}/page/diary/diary_list.htm?did=".$dr->did."';</script>";
			} else {
				echo "<script>alert('�߸��� ��й�ȣ�Դϴ�.'); window.history.back();</script>";
			}
		} else {
			echo "<script>alert('�������� �ʴ� ������Դϴ�.'); window.history.back();</script>";
		}
	}
?>