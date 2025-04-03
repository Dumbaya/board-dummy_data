<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.boardVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$board_title = $_POST["board_title"];
		$board_writer = $_SESSION['user_nickname'];
		$board_body = $_POST["board_body"];
		$board_date = date("Y-m-d H:i:s");

		$img_name = 'board_img';
		$dir_path = '../../img/board/';

		$bv = new boardVO();

		$bv->board_set($board_title, $board_writer, $board_body, $board_date);
		$bv->img_set($img_name, $dir_path, 1);

		if($bv->insert(1)){
			echo "<script>alert('성공적으로 업로드되었습니다.');</script>";
			echo "<script>window.location.href='http://localhost/page/board/board.htm?page=1';</script>";
		}
		else{
			echo "<script>alert('파일 업로드 중 오류가 발생했습니다.');</script>";
			echo "<script>window.location.href='http://localhost/page/board/board_write.htm';</script>";
		}
	}
?>