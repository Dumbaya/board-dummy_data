<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');
	session_destroy();

	echo "<script>alert('�α׾ƿ��Ǿ����ϴ�.'); window.location.href = 'http://localhost/page/homepage.htm';</script>";
	exit();
?>