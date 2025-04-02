function findLastGroupO($pdo, $group_id, $pa_bcid) {
    // 현재 부모 댓글의 group_o 찾기
    $sql = "SELECT group_o FROM board_comment WHERE bcid = :pa_bcid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':pa_bcid' => $pa_bcid]);
    $parent = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$parent) return 0; // 부모가 없으면 기본값 0

    $parent_group_o = $parent['group_o'];

    // 현재 부모 댓글의 가장 마지막 자식 찾기
    $sql = "SELECT bcid, group_o FROM board_comment 
            WHERE group_id = :group_id AND pa_bcid = :pa_bcid 
            ORDER BY group_o DESC LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':group_id' => $group_id, ':pa_bcid' => $pa_bcid]);
    $last_child = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($last_child) {
        // 자식이 있으면, 그 자식의 마지막 자손을 찾아야 함 (재귀 호출)
        return findLastGroupO($pdo, $group_id, $last_child['bcid']);
    } else {
        // 자식이 없으면, 부모의 바로 다음 위치로 설정
        return $parent_group_o + 1;
    }
}

function insertComment($f_bid, $pa_bcid, $comment, $writer) {
    global $pdo;

    if ($pa_bcid == 0) {
        // 최상위 부모 댓글
        $group_id = null; // 나중에 bcid로 업데이트
        $depth = 0;
        $group_o = 0;
    } else {
        // 부모 댓글 정보 가져오기
        $sql = "SELECT group_id, depth FROM board_comment WHERE bcid = :pa_bcid";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':pa_bcid' => $pa_bcid]);
        $parent = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$parent) return false;

        $group_id = $parent['group_id'];
        $depth = $parent['depth'] + 1;

        // 재귀적으로 마지막 group_o 찾기
        $group_o = findLastGroupO($pdo, $group_id, $pa_bcid);
    }

    // 새 댓글 삽입
    $sql = "INSERT INTO board_comment (f_bid, pa_bcid, group_id, group_o, depth, bc_comment, bc_writer, bc_date)
            VALUES (:f_bid, :pa_bcid, :group_id, :group_o, :depth, :bc_comment, :bc_writer, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':f_bid' => $f_bid,
        ':pa_bcid' => $pa_bcid,
        ':group_id' => $group_id,
        ':group_o' => $group_o,
        ':depth' => $depth,
        ':bc_comment' => $comment,
        ':bc_writer' => $writer
    ]);

    // 최상위 부모 댓글이면 group_id 업데이트
    if ($pa_bcid == 0) {
        $lastId = $pdo->lastInsertId();
        $sql = "UPDATE board_comment SET group_id = :group_id WHERE bcid = :bcid";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':group_id' => $lastId, ':bcid' => $lastId]);
    }

    return true;
}
