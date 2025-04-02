<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');
	session_destroy();

	echo "<script>alert('로그아웃되었습니다.'); window.location.href = 'http://{도메인}/page/homepage.htm';</script>";
	exit();
?>