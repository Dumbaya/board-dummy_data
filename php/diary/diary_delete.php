<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.diaryVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$dlid = $_GET['dlid'];
		$did = $_GET['did'];

		$dv = new diaryVO();

		$dv->setdlid($dlid);

		//board �����
		$d_sql = "delete from diary_list where dlid=$dlid";

		if ($dv->delete(1)) {
			echo "<script>alert('�Խñ� ���� ����!');</script>";
			echo "<script>window.location.href='http://localhost/page/diary/diary_list.htm?did=".$did."';</script>";
		} else {
			echo "<script>alert('�Խñ� ���� ����!');</script>";
			echo "<script>window.location.href='http://localhost/page/diary/diary_read.htm?dlid="."$did"."';</script>";
		}
	}
?>