function findLastGroupO($pdo, $group_id, $pa_bcid) {
    // ���� �θ� ����� group_o ã��
    $sql = "SELECT group_o FROM board_comment WHERE bcid = :pa_bcid";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':pa_bcid' => $pa_bcid]);
    $parent = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$parent) return 0; // �θ� ������ �⺻�� 0

    $parent_group_o = $parent['group_o'];

    // ���� �θ� ����� ���� ������ �ڽ� ã��
    $sql = "SELECT bcid, group_o FROM board_comment 
            WHERE group_id = :group_id AND pa_bcid = :pa_bcid 
            ORDER BY group_o DESC LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':group_id' => $group_id, ':pa_bcid' => $pa_bcid]);
    $last_child = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($last_child) {
        // �ڽ��� ������, �� �ڽ��� ������ �ڼ��� ã�ƾ� �� (��� ȣ��)
        return findLastGroupO($pdo, $group_id, $last_child['bcid']);
    } else {
        // �ڽ��� ������, �θ��� �ٷ� ���� ��ġ�� ����
        return $parent_group_o + 1;
    }
}

function insertComment($f_bid, $pa_bcid, $comment, $writer) {
    global $pdo;

    if ($pa_bcid == 0) {
        // �ֻ��� �θ� ���
        $group_id = null; // ���߿� bcid�� ������Ʈ
        $depth = 0;
        $group_o = 0;
    } else {
        // �θ� ��� ���� ��������
        $sql = "SELECT group_id, depth FROM board_comment WHERE bcid = :pa_bcid";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':pa_bcid' => $pa_bcid]);
        $parent = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$parent) return false;

        $group_id = $parent['group_id'];
        $depth = $parent['depth'] + 1;

        // ��������� ������ group_o ã��
        $group_o = findLastGroupO($pdo, $group_id, $pa_bcid);
    }

    // �� ��� ����
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

    // �ֻ��� �θ� ����̸� group_id ������Ʈ
    if ($pa_bcid == 0) {
        $lastId = $pdo->lastInsertId();
        $sql = "UPDATE board_comment SET group_id = :group_id WHERE bcid = :bcid";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':group_id' => $lastId, ':bcid' => $lastId]);
    }

    return true;
}
