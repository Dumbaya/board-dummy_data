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
			echo "<script>alert('이미지가 성공적으로 업로드되었습니다.');</script>";
			echo "<script>window.location.href='http://{도메인}/page/bonoga/gallery.htm';</script>";
		}
		else{
			echo "<script>alert('파일 업로드 중 오류가 발생했습니다.');</script>";
			echo "<script>window.location.href='http://{도메인}/page/bonoga/imgframe_write.htm';</script>";
		}
	}
?>