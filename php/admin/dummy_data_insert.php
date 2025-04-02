<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.dummyVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$mode = $_POST['mode'];
		$count = $_POST["count"];

		$dv = new dummyVO();

		if($dv->insert($mode, $count)){
			echo "<script>alert('테스트 데이터 삽입 ".$count."개 성공!"."\\n"."혹시 모르니 데이터 확인해주세요');</script>";
			echo "<script>window.location.href='http://{도메인}/page/admin/test_data_insert.htm';</script>";
		} else{
			$dv->set_ai(1);
			echo "<script>alert('테스트 데이터 삽입 실패!');</script>";
			echo "<script>window.location.href='http://{도메인}/page/admin/test_data_insert.htm';</script>";
		}
	}
?>