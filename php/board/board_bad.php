<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.boardVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$f_bid = $_GET['bid'];
		$tmp_num_mb = $_POST['tmp_num_mb'];
		$bg_user = $_SESSION["user_nickname"];
		$bg_check=1;

		$bv = new boardVO();
		$bv->setbid($f_bid);

		if(isset($bg_user)==false){
			echo "<script>alert('�α��� �� �̿����ּ���');</script>";
			echo "<script>window.location.href='http://{������}/page/user/login.htm?tmp_num=2&bid=".$f_bid."&tmp_num_mb=".$tmp_num_mb."';</script>";
		}
		else{
			//�������� ���� bgbid���� �����ϱ� ������ �̸� ���߱� ����
			$tmp_bgbid = $bv->set_max_id(3);

			$bv->bg_set($f_bid, $tmp_bgbid, $bg_user, $bg_check);
			$bv->setbid($f_bid);

			//�ش� �Խñۿ� ���� ��õ�� �ߴ��� Ȯ�ο�
			$gb_result = $bv->check_select(1);

			if($gb_result==0){
				if ($bv->insert(4) && $bv->update(5)) {
					echo "<script>alert('�Խ��� ����õ ����!');</script>";
					echo "<script>window.location.href='http://{������}/page/board/board_read.htm?page=1&bid=".$f_bid."&tmp_num=".$tmp_num_mb."';</script>";
				} else {
					echo "<script>alert('�Խ��� ����õ ����!');</script>";
					echo "<script>window.history.back();</script>";
				}
			}
			else if($gb_result==1){
				if ($bv->delete(3) && $bv->update(4)) {
					echo "<script>alert('�Խ��� ����õ ��� ����!');</script>";
					echo "<script>window.location.href='http://{������}/page/board/board_read.htm?page=1&bid=".$f_bid."&tmp_num=".$tmp_num_mb."';</script>";
				} else {
					echo "<script>alert('�Խ��� ����õ ��� ����!');</script>";
					echo "<script>window.history.back();</script>";
				}
			}
		}
	}
?>