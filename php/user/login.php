<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.userVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$tmp_num = $_POST['tmp_num'];
		$tmp_num_mb = $_POST['tmp_num_mb'];
		$bid = $_POST['bid'];
		$user_id = $_POST["user_id"];
		$user_password = $_POST["user_password"];

		$com = new common();
		$enc_password = $com->aes128_encode($user_password);

		$uv = new userVO();
		$uv->user_id_con($user_id);
		$f_search=array("user_id" => $user_id);
		$row = $uv->selectList($f_search, 2);
		$userVO = $row[0];
		if($row){
			if (strcmp($enc_password, $userVO->user_password)==0) {
				$com->setSession($user_id, $userVO->user_nickname, $userVO->user_role);
				switch($tmp_num){
					case 0:
						echo "<script>alert('�α��� ����!'); window.location.href = 'http://localhost/page/homepage.htm';</script>";
						break;
					case 1:
						echo "<script>alert('�α��� ����!'); window.location.href = 'http://localhost/page/board/board_write.htm';</script>";
						break;
					case 2:
						echo "<script>alert('�α��� ����!'); window.location.href = 'http://localhost/page/board/board_read.htm?page=1&bid=".$bid."&tmp_num=".$tmp_num_mb."';</script>";
						break;
					case 3:
						echo "<script>alert('�α��� ����!'); window.location.href = 'http://localhost/page/bonoga/imgframe_write.htm';</script>";
						break;
					case 4:
						echo "<script>alert('�α��� ����!'); window.location.href = 'http://localhost/page/bonoga/gallery.htm';</script>";
						break;
				}
			} else {
				echo "<script>alert('�߸��� ��й�ȣ�Դϴ�.'); window.history.back();</script>";
			}
		} else {
			echo "<script>alert('�������� �ʴ� ������Դϴ�.'); window.history.back();</script>";
		}
	}
?>