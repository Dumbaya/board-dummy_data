<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		echo "<script>self.close(); window.opener.location='http://{������}/page/diary/for_diary_password.htm';</script>";
	}
?>