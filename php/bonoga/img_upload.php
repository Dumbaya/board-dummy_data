<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.bonogaVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$img_title = $_POST["img_title"];
		$img_writer = $_SESSION['user_nickname'];
		$img_date = date("Y-m-d H:i:s");

		$bv = new bonogaVO();

		$img_name = 'img';
		$uploadDir = "../../img/bonoga/";

		$bv->bonoga_set($img_title, $img_writer, $img_date);
		$bv->img_set($img_name, $uploadDir);
		
		if($bv->insert()){
			echo "<script>alert('�̹����� ���������� ���ε�Ǿ����ϴ�.');</script>";
			echo "<script>window.location.href='http://{������}/page/bonoga/gallery.htm';</script>";
		}
		else{
			echo "<script>alert('���� ���ε� �� ������ �߻��߽��ϴ�.');</script>";
			echo "<script>window.location.href='http://{������}/page/bonoga/imgframe_write.htm';</script>";
		}
	}
?>