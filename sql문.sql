CREATE DATABASE IF NOT EXISTS `study_board` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `study_board`;

/*----------------------------------------------------------------------------------------------*/

CREATE TABLE IF NOT EXISTS `user` (
  `uid` int(10) NOT NULL AUTO_INCREMENT COMMENT '유저 고유 id',
  `user_id` varchar(50) NOT NULL COMMENT '유저 로그인 id',
  `user_password` varchar(128) NOT NULL COMMENT '유저 로그인 password && sha256 or aes128 사용',
  `user_nickname` varchar(50) NOT NULL COMMENT '유저 별명',
  `user_email` varchar(100) NOT NULL COMMENT '유저 이메일',
  `user_role` int(1) NOT NULL DEFAULT '1' COMMENT '유저 권한(관리자 : 2, 일반 유저 : 1)',
  `is_dummy` int(11) NOT NULL DEFAULT '2' COMMENT '더미데이터 유무(더미:1, 더미x:2)',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `user_nickname` (`user_nickname`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=UTF8MB4;

/*----------------------------------------------------------------------------------------------*/

CREATE TABLE IF NOT EXISTS `board` (
  `bid` int(11) NOT NULL COMMENT '게시판 고유 id',
  `board_title` varchar(20) NOT NULL COMMENT '게시판 제목',
  `board_writer` varchar(20) NOT NULL COMMENT '게시판 작성자',
  `board_body` varchar(500) NOT NULL COMMENT '게시판 내용',
  `board_date` datetime NOT NULL COMMENT '게시판 작성 날짜',
  `board_imgp` varchar(255) DEFAULT '',
  `board_view` int(11) NOT NULL DEFAULT '0' COMMENT '게시판 조회수',
  `board_gb` int(11) NOT NULL DEFAULT '0' COMMENT '게시판 추천수',
  `is_dummy` int(11) NOT NULL DEFAULT '2' COMMENT '더미데이터 유무(더미:1, 더미x:2)',
  PRIMARY KEY (`bid`),
  KEY `FK_board_user` (`board_writer`),
  CONSTRAINT `FK_board_user` FOREIGN KEY (`board_writer`) REFERENCES `user` (`user_nickname`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;

/*----------------------------------------------------------------------------------------------*/

CREATE TABLE IF NOT EXISTS `board_gb` (
  `f_bid` int(11) NOT NULL COMMENT 'bid 가져옴',
  `bgbid` int(11) NOT NULL COMMENT '추천비추천 id',
  `bg_user` varchar(20) NOT NULL DEFAULT '' COMMENT '기능 사용한 유저',
  `bg_check` int(11) NOT NULL DEFAULT '0' COMMENT '추천:0, 비추천:1',
  PRIMARY KEY (`bgbid`),
  KEY `FK_board_gb_board` (`f_bid`),
  KEY `FK_board_gb_user` (`bg_user`),
  CONSTRAINT `FK_board_gb_board` FOREIGN KEY (`f_bid`) REFERENCES `board` (`bid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_board_gb_user` FOREIGN KEY (`bg_user`) REFERENCES `user` (`user_nickname`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*----------------------------------------------------------------------------------------------*/

CREATE TABLE IF NOT EXISTS `board_comment` (
  `f_bid` int(11) NOT NULL COMMENT 'bid 가져오기',
  `bcid` int(11) NOT NULL AUTO_INCREMENT COMMENT '댓글 id',
  `pa_bcid` int(11) NOT NULL DEFAULT '0' COMMENT '대댓글을 위한 댓글 id',
  `group_id` int(11) NOT NULL COMMENT '참조하는 댓글 id 값을 가지는 group id',
  `group_o` int(11) NOT NULL DEFAULT '0' COMMENT 'group id의 순서',
  `depth` int(11) NOT NULL DEFAULT '0' COMMENT '대댓글 깊이',
  `bc_comment` varchar(50) NOT NULL COMMENT '댓글 내용',
  `bc_writer` varchar(20) NOT NULL COMMENT '댓글 작성자',
  `bc_date` datetime NOT NULL COMMENT '댓글 작성 날짜',
  `bc_gb` int(11) NOT NULL DEFAULT '0' COMMENT '댓글 좋아요',
  `is_delete` int(11) NOT NULL DEFAULT '0' COMMENT '0은 삭제 안됨, 1은 삭제 됨',
  `is_dummy` int(11) NOT NULL DEFAULT '2' COMMENT '더미데이터 유무(더미:1, 더미x:2)',
  PRIMARY KEY (`bcid`),
  KEY `FK_board_comment_board` (`f_bid`),
  KEY `FK_board_comment_user` (`bc_writer`),
  KEY `idx_f_bid` (`f_bid`),
  KEY `idx_bc_writer` (`bc_writer`),
  KEY `idx_bc_date` (`bc_date`),
  CONSTRAINT `FK_board_comment_board` FOREIGN KEY (`f_bid`) REFERENCES `board` (`bid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_board_comment_user` FOREIGN KEY (`bc_writer`) REFERENCES `user` (`user_nickname`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1000032 DEFAULT CHARSET=UTF8MB4;

/*----------------------------------------------------------------------------------------------*/

CREATE TABLE IF NOT EXISTS `board_comment_gb` (
  `f_bid` int(11) NOT NULL COMMENT 'bid값 가져오기',
  `f_bcid` int(11) NOT NULL COMMENT 'bcid값 가져오기',
  `bcgbid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'bcgbid값',
  `bcgb_user` varchar(20) NOT NULL COMMENT 'bcgb 유저',
  `bcgb_check` int(11) NOT NULL DEFAULT '0' COMMENT '추천:0, 비추천:1',
  PRIMARY KEY (`bcgbid`),
  KEY `FK_board_comment_gb_board` (`f_bid`),
  KEY `FK_board_comment_gb_user` (`bcgb_user`),
  KEY `FK_board_comment_gb_board_comment` (`f_bcid`),
  CONSTRAINT `FK_board_comment_gb_board` FOREIGN KEY (`f_bid`) REFERENCES `board` (`bid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_board_comment_gb_board_comment` FOREIGN KEY (`f_bcid`) REFERENCES `board_comment` (`bcid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_board_comment_gb_user` FOREIGN KEY (`bcgb_user`) REFERENCES `user` (`user_nickname`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;

/*----------------------------------------------------------------------------------------------*/

CREATE TABLE IF NOT EXISTS `bonoga` (
  `iid` int(11) NOT NULL COMMENT '이미지 id 값',
  `img_path` varchar(255) NOT NULL COMMENT '이미지 path',
  `img_title` varchar(50) NOT NULL COMMENT '이미지 title',
  `img_writer` varchar(50) NOT NULL COMMENT '이미지 writer',
  `img_date` datetime NOT NULL COMMENT '이미지 date',
  `img_gb` int(11) NOT NULL DEFAULT '0' COMMENT '이미지 goodbad',
  PRIMARY KEY (`iid`),
  KEY `FK_bonoga_user` (`img_writer`),
  CONSTRAINT `FK_bonoga_user` FOREIGN KEY (`img_writer`) REFERENCES `user` (`user_nickname`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;

/*----------------------------------------------------------------------------------------------*/

CREATE TABLE IF NOT EXISTS `bonoga_gb` (
  `f_iid` int(11) NOT NULL COMMENT 'iid값',
  `bg_iid` int(11) NOT NULL COMMENT 'bg_iid',
  `bg_user` varchar(50) NOT NULL COMMENT 'bg 진행 유저',
  `bg_check` int(11) NOT NULL DEFAULT '0' COMMENT '추천:0, 비추천:1',
  PRIMARY KEY (`bg_iid`),
  KEY `FK_bonoga_gb_user` (`bg_user`) USING BTREE,
  KEY `FK_bonoga_gb_bonoga` (`f_iid`),
  CONSTRAINT `FK_bonoga_gb_bonoga` FOREIGN KEY (`f_iid`) REFERENCES `bonoga` (`iid`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_bonoga_gb_user` FOREIGN KEY (`bg_user`) REFERENCES `user` (`user_nickname`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;

/*----------------------------------------------------------------------------------------------*/

CREATE TABLE IF NOT EXISTS `diary_user` (
  `did` int(11) NOT NULL,
  `d_writer` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `d_password` varchar(64) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`did`),
  UNIQUE KEY `d_writer` (`d_writer`),
  CONSTRAINT `FK_diary_user_user` FOREIGN KEY (`d_writer`) REFERENCES `user` (`user_nickname`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*----------------------------------------------------------------------------------------------*/

CREATE TABLE IF NOT EXISTS `diary_list` (
  `dlid` int(11) NOT NULL AUTO_INCREMENT COMMENT '다이어리 리스트 id',
  `f_did` int(11) NOT NULL COMMENT 'did값 가져오기',
  `dl_title` varchar(50) CHARACTER SET utf8mb4 NOT NULL COMMENT '다이어리 리스트 title',
  `dl_body` varchar(50) CHARACTER SET utf8mb4 NOT NULL COMMENT '다이어리 리스트 body',
  `dl_date` datetime NOT NULL COMMENT '다이어리 리스트 date',
  `dl_imgp` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '다이어리 리스트 imgpath',
  PRIMARY KEY (`dlid`),
  KEY `FK_diary_list_diary_user` (`f_did`),
  CONSTRAINT `FK_diary_list_diary_user` FOREIGN KEY (`f_did`) REFERENCES `diary_user` (`did`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

/*----------------------------------------------------------------------------------------------*/

CREATE TABLE IF NOT EXISTS `announ_board` (
  `aid` int(11) NOT NULL AUTO_INCREMENT COMMENT '게시글 공지 id',
  `a_title` varchar(50) NOT NULL DEFAULT '' COMMENT '게시글 공지 title',
  `a_body` varchar(50) NOT NULL DEFAULT '' COMMENT '게시글 공지 body',
  `a_writer` varchar(20) NOT NULL DEFAULT '' COMMENT '게시글 공지 writer',
  `a_date` datetime NOT NULL COMMENT '게시글 공지 date',
  `a_imgp` varchar(255) NOT NULL DEFAULT '' COMMENT '게시글 공지 img_path',
  PRIMARY KEY (`aid`),
  KEY `FK__user` (`a_writer`),
  CONSTRAINT `FK__user` FOREIGN KEY (`a_writer`) REFERENCES `user` (`user_nickname`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=UTF8MB4;

/*----------------------------------------------------------------------------------------------*/

CREATE TABLE IF NOT EXISTS `announ_bonoga` (
  `aid` int(11) NOT NULL AUTO_INCREMENT COMMENT '갤러리 공지 id',
  `a_title` varchar(50) CHARACTER SET utf8mb4 NOT NULL COMMENT '갤러리 공지 title',
  `a_body` varchar(50) CHARACTER SET utf8mb4 NOT NULL COMMENT '갤러리 공지 body',
  `a_writer` varchar(20) CHARACTER SET utf8mb4 NOT NULL DEFAULT '' COMMENT '갤러리 공지 writer',
  `a_date` datetime NOT NULL COMMENT '갤러리 공지 date',
  `a_imgp` varchar(255) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  PRIMARY KEY (`aid`),
  KEY `FK_announ_bonoga_user` (`a_writer`),
  CONSTRAINT `FK_announ_bonoga_user` FOREIGN KEY (`a_writer`) REFERENCES `user` (`user_nickname`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=UTF8;

/*----------------------------------------------------------------------------------------------*/

DELIMITER //
CREATE PROCEDURE `findlg`(IN groupid INT, IN pabcid INT, OUT result INT)
BEGIN
	DECLARE tmp_go INT;
	DECLARE lc_id INT;
	DECLARE lc_go INT;
	
	find_block: BEGIN
		SELECT group_o FROM board_comment WHERE bcid=pabcid INTO tmp_go;
		
		IF tmp_go IS NULL THEN
			SET result=0;
			LEAVE find_block;
		END IF;
		
		SELECT bcid, group_o FROM board_comment WHERE group_id=groupid AND pa_bcid=pabcid ORDER BY group_o DESC LIMIT 1 INTO lc_id, lc_go;
		
		IF lc_id IS NOT NULL THEN
			CALL findlg(groupid, lc_id, result);
	   ELSE
	   	SET result = tmp_go+1;
	   END IF;
	END find_block;
END//
DELIMITER ;