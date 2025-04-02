<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$tmp_num_mb = $_POST['tmp_num_mb'];

		switch($tmp_num_mb){
			case 1:
				echo "<script>window.location.href='http://{도메인}/page/board/board.htm';</script>";
				break;
			case 2:
				echo "<script>window.location.href='http://{도메인}/page/user/user_writeboard_about.htm';</script>";
				break;
			case 3:
				echo "<script>window.location.href='http://{도메인}/page/user/user_writebc_about.htm';</script>";
				break;
		}
	}
?>