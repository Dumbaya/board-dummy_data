<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.bonogaVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$iid = $_POST["iid"];
		$img_title = $_POST["img_title"];
		$img_writer = $_SESSION['user_nickname'];
		

		$bv = new bonogaVO();

		$img_name = 'img';
		$uploadDir = "../../img/bonoga/";

		$bv->setiid($iid);
		$bv->setimg_title($img_title);
		$bv->img_set($img_name, $uploadDir);

			if($bv->update(1)){
				echo "<script>alert('이미지가 성공적으로 수정되었습니다.');</script>";
				echo "<script>window.location.href='http://{도메인}/page/bonoga/gallery.htm'</script>";
			}
			else{
				echo "<script>alert('파일 업로드 중 오류가 발생했습니다.');</script>";
				echo "<script>window.history.back();</script>";
			}
		}
?>