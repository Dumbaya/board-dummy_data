<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.dummyVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$mode = $_POST['mode'];
		$count = $_POST["count"];

		$dv = new dummyVO();

		if($dv->insert($mode, $count)){
			echo "<script>alert('�׽�Ʈ ������ ���� ".$count."�� ����!"."\\n"."Ȥ�� �𸣴� ������ Ȯ�����ּ���');</script>";
			echo "<script>window.location.href='http://{������}/page/admin/test_data_insert.htm';</script>";
		} else{
			$dv->set_ai(1);
			echo "<script>alert('�׽�Ʈ ������ ���� ����!');</script>";
			echo "<script>window.location.href='http://{������}/page/admin/test_data_insert.htm';</script>";
		}
	}
?>