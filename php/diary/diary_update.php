<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.diaryVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$dlid = $_GET['dlid'];
		$dl_title = $_POST["dl_title"];
		$dl_body = $_POST["dl_body"];

		$img_name = 'diary_img';
		$dir_path = '../../img/diary/';

		$dv = new diaryVO();

		$dv->diary_list_upd_set($dlid, $dl_title, $dl_body);
		$dv->img_set($img_name, $dir_path);

		if($dv->update(2)){
			echo "<script>alert('�ϱⰡ ���������� �����Ǿ����ϴ�.');</script>";
			echo "<script>window.location.href='http://localhost/page/diary/diary_read.htm?dlid=".$dlid."'</script>";
		}
		else{
			echo "<script>alert('���� ���ε� �� ������ �߻��߽��ϴ�.');</script>";
			echo "<script>window.history.back();</script>";
		}
	}
?>