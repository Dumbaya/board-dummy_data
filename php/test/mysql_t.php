<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>MySql-PHP ���� �׽�Ʈ</title>
</head>
<body>
<?phpphp echo "MySql ���� �׽�Ʈ<br>"; $db = mysqli_connect("mymysql", "root", "root", "study_board");
if($db){ echo "connect : ����<br>";
} else{ echo "disconnect : ����<br>";
}
$result = mysqli_query($db, 'SELECT VERSION() as VERSION');
$data = mysqli_fetch_assoc($result); echo $data['VERSION']; 
$test=1;
$sql = "insert into test values(test=:test)";
$stmt = $db->prepare($sql);
$stmt->bind_param();

if ($result->num_rows > 0) {
	while ($row = $result->fetch_assoc()) {
			echo "ID: " . $row["user_id"] . " - Name: " . $row["user_nickname"] . "<br>";
	}
} else {
	echo "����� �����ϴ�.";
}

$db->close();
?>
</body>
</html>