<?php
	$hostname="mymysql";
	$username="root";
	$password="root";
	$dbname="study_board";
	
	$con = new mysqli($hostname, $username, $password, $dbname);
	
	if ($con->connect_error) {
    die("���� ����: " . $con->connect_error);
	}
	echo "<script>console.log('MySQL �����ͺ��̽��� ���������� ����Ǿ����ϴ�.')</script>";

	$con->set_charset('utf8mb4');
	
	$secret_key = "study_board_secret_key";
	//�� db.php�� ������ �� ����ϰ� �� �������� mysqli_close($con); ���ֱ�
?>