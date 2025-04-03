<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.diaryVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$dl_title = $_POST["diary_title"];
		$dl_body = $_POST["diary_body"];
		$f_did = $_POST['f_did'];
		$dl_date = date("Y-m-d H:i:s");

		$img_name = 'diary_img';
		$dir_path = '../../img/diary/';

		$dv = new diaryVO();
		
		$dv->diary_list_set($f_did, $dl_title, $dl_body, $dl_date);
		$dv->img_set($img_name, $dir_path);

		if($dv->insert(2)){
			echo "<script>alert('성공적으로 업로드되었습니다.');</script>";
			echo "<script>window.location.href='http://localhost/page/diary/diary_list.htm?did=".$f_did."'</script>";
		}
		else{
			$dv->set_ai();
			echo "<script>alert('파일 업로드 중 오류가 발생했습니다.');</script>";
			echo "<script>window.history.back();</script>";
		}
	}

	
?>