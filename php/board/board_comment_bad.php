<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.boardVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$f_bcid = $_GET['bcid'];
		$tmp_num_mb = $_POST['tmp_num_mb'];
		$f_bid = $_POST['bc_for_bad'];
		$bcgb_user = $_SESSION["user_nickname"];
		$bcgb_check=1;

		if(isset($bcgb_user)==false){
			echo "<script>alert('�α��� �� �̿����ּ���');</script>";
			echo "<script>window.location.href='http://localhost/page/user/login.htm?tmp_num=2&bid=".$f_bid."&tmp_num_mb=".$tmp_num_mb."';</script>";
		}

		$bv = new boardVO();

		//�������� ���� bgbid���� �����ϱ� ������ �̸� ���߱� ����
		$bcgbid = $bv->set_max_id(4);

		$bv->bcgb_set($f_bid, $f_bcid, $bcgbid, $bcgb_user, $bcgb_check);

		//�ش� �Խñۿ� ���� ��õ�� �ߴ��� Ȯ�ο�
		$cnt_row = $bv->check_select(2);
		
		if($cnt_row==0){
			if ($bv->insert(6) && $bv->update(11)) {
				echo "<script>alert('��� ����õ ����!');</script>";
				echo "<script>window.location.href='http://localhost/page/board/board_read.htm?page=1&bid=".$f_bid."&tmp_num=".$tmp_num_mb."';</script>";
			} else {
				echo "<script>alert('��� ����õ ����!');</script>";
				echo "<script>window.history.back();</script>";
			}
		}
		else if($cnt_row==1){
			if ($bv->delete(4) && $bv->update(10)) {
				echo "<script>alert('��� ����õ ��� ����!');</script>";
				echo "<script>window.location.href='http://localhost/page/board/board_read.htm?page=1&bid=".$f_bid."&tmp_num=".$tmp_num_mb."';</script>";
			} else {
				echo "<script>alert('��� ����õ ��� ����!');</script>";
				echo "<script>window.history.back();</script>";
			}
		}
	}
?>