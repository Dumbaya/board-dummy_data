<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.boardVO.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/class.common.php');
	$pdo = new PDO("mysql:host=mysql_test;dbname=study_board;charset=utf8mb4", "root", "root");
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$bcid = $_POST['bcid'];
		$f_bid = $_POST['f_bid'];
		$group_id = $_POST['group_id'];
		$bc_comment = $_POST['bcc_comment'];
		$tmp_num_mb = $_POST['tmp_num_mb'];
		$bc_writer = $_SESSION["user_nickname"];
		$bc_date = date("Y-m-d H:i:s");

		$bv = new boardVO();
		$tmp_bcid = $bv->set_max_id(2);
		$tmp_pabcid = $bcid;

		$sql = "SELECT depth FROM board_comment WHERE bcid = :pa_bcid";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':pa_bcid' => $tmp_pabcid]);
        $parent = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$parent) return false;

        $depth = $parent['depth'] + 1;

        $group_o = findLastGroupO($pdo, $group_id, $tmp_pabcid);

		$sql = "UPDATE board_comment 
				SET group_o = group_o + 1 
				WHERE group_id = :group_id AND group_o >= :insert_group_o";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([':group_id' => $group_id, ':insert_group_o' => $group_o]);

		$sql = "INSERT INTO board_comment (f_bid, bcid, pa_bcid, group_id, group_o, depth, bc_comment, bc_writer, bc_date)
            VALUES (:f_bid, :bcid, :pa_bcid, :group_id, :group_o, :depth, :bc_comment, :bc_writer, :bc_date)";
		$stmt = $pdo->prepare($sql);
		if($stmt->execute([
			':f_bid' => $f_bid,
			':bcid' => $tmp_bcid,
			':pa_bcid' => $tmp_pabcid,
			':group_id' => $group_id,
			':group_o' => $group_o,
			':depth' => $depth,
			':bc_comment' => $bc_comment,
			':bc_writer' => $bc_writer,
			':bc_date' => $bc_date
		])){
			echo "<script>alert('대댓글 작성 성공!');</script>";
			echo "<script>self.close(); window.opener.location='http://{도메인}/page/board/board_read.htm?bid=".$f_bid."&tmp_num=".$tmp_num_mb."';</script>";
		} else {
			echo "<script>alert('대댓글 작성 실패!');</script>";
			echo "<script>window.history.back();</script>";
		}
	}
	function findLastGroupO($pdo, $group_id, $pa_bcid) {
		$sql = "SELECT group_o FROM board_comment WHERE bcid = :pa_bcid";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([':pa_bcid' => $pa_bcid]);
		$parent = $stmt->fetch(PDO::FETCH_ASSOC);
	
		if (!$parent) return 0;
	
		$parent_group_o = $parent['group_o'];
	
		$sql = "SELECT bcid, group_o FROM board_comment 
				WHERE group_id = :group_id AND pa_bcid = :pa_bcid 
				ORDER BY group_o DESC LIMIT 1";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([':group_id' => $group_id, ':pa_bcid' => $pa_bcid]);
		$last_child = $stmt->fetch(PDO::FETCH_ASSOC);
	
		if ($last_child) {
			return findLastGroupO($pdo, $group_id, $last_child['bcid']);
		} else {
			return $parent_group_o + 1;
		}
	}
?>