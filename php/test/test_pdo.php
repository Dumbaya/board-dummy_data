<?phpphp
include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/DB.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.userVO.php');
include_once '../class/commonDAO.php';

try {
    // INSERT �׽�Ʈ
    $user_id = "�׽�Ʈ ���̵�";
		$user_password = "�׽�Ʈ ��й�ȣ";
		$user_nickname = "�׽�Ʈ �г���";
		$user_email = "�׽�Ʈ �̸���";

		// $uv = new userVO();
    // $uv->initialize($user_id, $user_password, $user_nickname, $user_email);
    // $uv->insert();


    $uv = new userVO();
    $uv->user_nickname_con($user_nickname);
    $f_search=array("user_nickname" => $user_nickname);
    $row = $uv->selectList($f_search);
    echo "test";
    foreach($row as $userVO){
      echo $userVO->user_id."<br>";
      echo $userVO->user_nickname."<br>";
    }
} catch (PDOException $e) {
    echo "���� �߻�: " . $e->getMessage();
}
?>
