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
				echo "<script>alert('�̹����� ���������� �����Ǿ����ϴ�.');</script>";
				echo "<script>window.location.href='http://{������}/page/bonoga/gallery.htm'</script>";
			}
			else{
				echo "<script>alert('���� ���ε� �� ������ �߻��߽��ϴ�.');</script>";
				echo "<script>window.history.back();</script>";
			}
		}
?>