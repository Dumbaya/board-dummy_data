<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.userVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$user_nickname = $_SESSION["user_nickname"];
		$user_password = $_POST["user_password"];

		$com = new common();
		$enc_password = $com->aes128_encode($user_password);

		$uv = new userVO();
		$uv->user_nickname_con($user_nickname);
		$f_search = array("user_nickname" => $user_nickname);
		$row = $uv->selectList($f_search, 1);
		$userVO = $row[0];
		if($row){
			if(strcmp($enc_password, $userVO->user_password)==0){
				echo "<script>alert('인증 성공!'); window.location.href = 'http://localhost/page/user/myaccount.htm?uid=".$userVO->uid."';</script>";
			} else {
				echo "<script>alert('잘못된 비밀번호입니다.'); window.history.back();</script>";
			}
		}
	}
?>