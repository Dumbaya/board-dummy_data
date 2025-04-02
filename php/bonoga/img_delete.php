<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.bonogaVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$iid = $_POST['iid'];

		$bv = new bonogaVO();
		$bv->setiid($iid);

		if ($bv->delete(1)) {
			echo "<script>alert('앨범 삭제 성공!');</script>";
			echo "<script>self.close(); opener.location.reload();</script>";
		} else {
			echo "<script>alert('앨범 삭제 실패!');</script>";
			echo "<script>self.close(); window.history.back();</script>";
		}
	}
?>