<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.bonogaVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$f_iid = $_POST['iid'];
		$bg_user = $_SESSION["user_nickname"];
		$bg_check = 1;

		if(isset($bg_user)==false){
			echo "<script>alert('로그인 후 이용해주세요');</script>";
			echo "<script>window.location.href='http://localhost/page/user/login.htm?tmp_num=4';</script>";
		}
		else{
			$bv = new bonogaVO();

			$bv->board_gb_set($f_iid, $bg_user, $bg_check);
			$bv->setiid($f_iid);

			$gb_result = $bv->select(7);

			if($gb_result==0){
				if ($bv->insert(3) && $bv->update(4)) {
					echo "<script>alert('사진 비추천 성공!');</script>";
					echo "<script>window.location.href='http://localhost/page/bonoga/gallery.htm?page=1';</script>";
				} else {
					echo "<script>alert('사진 비추천 실패!');</script>";
					echo "<script>window.history.back();</script>";
				}
			}
			else if($gb_result==1){
				if ($bv->insert(3) && $bv->update(3)) {
					echo "<script>alert('사진 비추천 취소 성공!');</script>";
					echo "<script>window.location.href='http://localhost/page/bonoga/gallery.htm?page=1';</script>";
				} else {
					echo "<script>alert('사진 비추천 취소 실패!');</script>";
					echo "<script>window.history.back();</script>";
				}
			}
		}
	}

	$con->close();
?>