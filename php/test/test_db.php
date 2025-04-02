<?phpphp
class DB {
    private $pdo;

    // DB 연결 설정
    private $hostname = "mymysql";  // 또는 "localhost"
    private $dbname = "study_board";
    private $username = "root";
    private $password = "root";

    public function __construct() {
        try {
            $dsn = "mysql:host=$this->hostname;dbname=$this->dbname;charset=utf8mb4";
            $this->pdo = new PDO($dsn, $this->username, $this->password);

            // 에러 모드를 예외로 설정
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "<script>console.log('PDO 연결 성공')</script>";
        } catch (PDOException $e) {
            die("PDO 연결 실패: " . $e->getMessage());
        }
    }

    // PDO 객체 반환
    public function getPDO() {
        return $this->pdo;
    }
}
?>
