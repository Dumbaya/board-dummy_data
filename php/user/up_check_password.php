<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.userVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$user_nickname = $_SESSION["user_nickname"];
		$user_password = $_POST["user_password"];
		$tmp_num = $_POST['tmp_num'];

		$com = new common();
		$enc_password = $com->aes128_encode($user_password);

		$uv = new userVO();
		$uv->user_nickname_con($user_nickname);
		$f_search = array("user_nickname" => $user_nickname);
		$row = $uv->selectList($f_search, 1);
		$userVO = $row[0];

		if ($row) {
			if (strcmp($enc_password, $userVO->user_password)==0) {
				switch($tmp_num){
					case 1:
						echo "<script>alert('���� ����!'); self.close(); window.opener.location = 'http://{������}/page/user/myaccount.htm?uid=".$uid."';</script>";
						break;
					case 2:
						echo "<script>alert('���� ����!'); self.close(); window.opener.location = 'http://{������}/page/user/user_writeboard_about.htm';</script>";
						break;
					case 3:
						echo "<script>alert('���� ����!'); self.close(); window.opener.location = 'http://{������}/page/user/user_writebc_about.htm';</script>";
						break;
					case 4:
						echo "<script>alert('���� ����!'); self.close(); window.opener.location = 'http://{������}/page/user/user_writeimg_about.htm';</script>";
						break;
				}
				
			} else {
				echo "<script>alert('�߸��� ��й�ȣ�Դϴ�.'); window.history.back();</script>";
			}
		}
	}
?>