<?php
	$hostname="mymysql";
	$username="root";
	$password="root";
	$dbname="study_board";
	
	$con = new mysqli($hostname, $username, $password, $dbname);
	
	if ($con->connect_error) {
    die("연결 실패: " . $con->connect_error);
	}
	echo "<script>console.log('MySQL 데이터베이스에 성공적으로 연결되었습니다.')</script>";

	$con->set_charset('utf8mb4');
	
	$secret_key = "study_board_secret_key";
	//이 db.php를 포함한 후 사용하고 맨 마지막에 mysqli_close($con); 해주기
?>