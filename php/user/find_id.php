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
			echo "<script>alert('������� ���̵�� ".$userVO->user_id." �Դϴ�.'); window.location.href='http://{������}/page/user/login.htm'; </script>";
		} else {
			echo "<script>alert('�������� �ʴ� ������Դϴ�.'); window.location.href='http://{������}/page/user/find_id.htm';</script>";
		}
	}
?>