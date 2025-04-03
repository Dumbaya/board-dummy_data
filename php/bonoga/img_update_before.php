<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$iid = $_POST['iid'];

		echo "<script>self.close(); window.opener.location = 'http://localhost¿Œ}/page/bonoga/img_update.htm?iid=".$iid."';</script>";

	}
?>