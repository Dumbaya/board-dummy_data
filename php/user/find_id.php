<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.userVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$fi_email = $_POST["fi_email"];

		$uv = new userVO();
		$uv->user_id_con($fi_email);
		$f_search = array("user_email" => $fi_email);
		$row = $uv->selectList($f_search, 3);
		$userVO = $row[0];
		if ($row) {
			echo "<script>alert('사용자의 아이디는 ".$userVO->user_id." 입니다.'); window.location.href='http://{도메인}/page/user/login.htm'; </script>";
		} else {
			echo "<script>alert('존재하지 않는 사용자입니다.'); window.location.href='http://{도메인}/page/user/find_id.htm';</script>";
		}
	}
?>