<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.dummyVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$mode = $_POST['mode'];
		
		$dv = new dummyVO();

		$count = $dv->chk_count($mode);
		
		if ($dv->delete($mode)) {
			if($mode==1){
				$dv->set_ai(1);
			}

			$dummy_cnt = $dv->chk_count($mode);
			$dv->del_cash($mode);
			$dv->optm($mode);

			echo "<script>alert('테스트 데이터 제거 ".($count-$dummy_cnt)."개 성공!"."\\n"."혹시 모르니 데이터 확인해주세요');</script>";
			echo "<script>window.location.href='http://localhost/page/admin/test_data_insert.htm';</script>";
		} else {
			echo "<script>alert('테스트 데이터 제거 실패!');</script>";
			echo "<script>window.history.back();</script>";
		}
	}
?>