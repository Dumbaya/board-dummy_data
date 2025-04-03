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
			echo "<script>alert('���������� ���ε�Ǿ����ϴ�.');</script>";
			echo "<script>window.location.href='http://localhost/page/diary/diary_list.htm?did=".$f_did."'</script>";
		}
		else{
			$dv->set_ai();
			echo "<script>alert('���� ���ε� �� ������ �߻��߽��ϴ�.');</script>";
			echo "<script>window.history.back();</script>";
		}
	}

	
?>