<?phpphp
include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/DB.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.userVO.php');
include_once '../class/commonDAO.php';

try {
    // INSERT 테스트
    $user_id = "테스트 아이디";
		$user_password = "테스트 비밀번호";
		$user_nickname = "테스트 닉네임";
		$user_email = "테스트 이메일";

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
    echo "에러 발생: " . $e->getMessage();
}
?>
