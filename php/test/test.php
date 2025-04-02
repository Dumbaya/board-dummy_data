CREATE PROCEDURE insertDummy(
    IN start_num INT,
    IN count_p INT,
    IN board_count INT
)
BEGIN
    DECLARE i INT DEFAULT start_num;
    DECLARE max_size INT DEFAULT 100000;
    DECLARE chk_cnt INT DEFAULT 0;
    DECLARE ran_fbid INT;
    DECLARE ran_bcid INT;
    DECLARE ran_pabcid INT;
    DECLARE ran_groupid INT;
    DECLARE ran_groupo INT;
    DECLARE ran_depth INT;
    
    -- 랜덤 board 선택
    SELECT FLOOR(1 + (RAND() * board_count)) INTO ran_fbid;

    -- 반복문 시작
    WHILE i <= count_p DO
        IF chk_cnt = 0 THEN
            START TRANSACTION;
        END IF;
        
        -- f_bid에 해당하는 최대 bcid 값 찾기, 만약 없으면 0으로 초기화
        SELECT COALESCE(MAX(bcid), 0) INTO ran_bcid FROM board_comment WHERE f_bid = ran_fbid;

        -- 랜덤으로 부모 댓글을 찾기
        SELECT bcid FROM board_comment WHERE f_bid = ran_fbid ORDER BY bcid DESC, RAND() LIMIT 1 INTO ran_pabcid;

        -- 부모 댓글의 group_id, group_o, depth 값 찾기
        SELECT group_id, group_o, depth FROM board_comment WHERE bcid = ran_pabcid INTO ran_groupid, ran_groupo, ran_depth;

        -- 댓글 삽입
        INSERT INTO board_comment (f_bid, bcid, pa_bcid, group_id, group_o, depth, bc_comment, bc_writer, bc_date, is_dummy)
        VALUES (ran_fbid, ran_bcid + 1, ran_pabcid, ran_groupid, ran_groupo + 1, ran_depth + 1, CONCAT('test_dummy', i), 'dummy_writer', NOW(), 1);

        SET i = i + 1;
        SET chk_cnt = chk_cnt + 1;

        -- 최대 삽입 건수까지 갔으면 COMMIT
        IF chk_cnt = max_size THEN
            COMMIT;
            SET chk_cnt = 0;
        END IF;
    END WHILE;
    
    -- 남은 데이터 COMMIT
    IF chk_cnt > 0 THEN
        COMMIT;
        SET chk_cnt = 0;
    END IF;
END;
