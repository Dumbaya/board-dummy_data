<!DOCTYPE html>
<html lang="ko">

<head>
	<meta charset="EUC-KR">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="http://{도메인}/js/header.js"></script>
	<link rel="stylesheet" href="http://{도메인}/css/common.css">
	<link rel="stylesheet" href="http://{도메인}/bootstrap/css/bootstrap.min.css">
	<script type="text/javascript" src="http://{도메인}/jquery/jquery-3.7.1.min.js"></script>
</head>
<body>
	<?php
		include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');
	?>
	<div class="header_div">
		<div class="hd">
			<a href="http://{도메인}/page/homepage.htm">
				<img src="http://{도메인}/img/home.png" id="home_img">
			</a>
		</div>

		<div class="hd">
			<h1 class="hd header_h1">게시판 만들기</h1>
		</div>

		<div class="hd">
			<input type="hidden">
		</div>
	</div>
	<div class="header_log">
		<?php if(isset($_SESSION['user_id'])): ?>
				<form class="ma_btn" name="ma_btn" method="post" onclick="user_openPopup()">
					<input type="hidden" id="sessionid" name="sessionid" value="<?php echo $_SESSION['user_id'] ?>">
					<button type="submit"><?php echo $_SESSION['user_nickname'] ?></button>
				</form>
        <form class="log_btn1" action="http://{도메인}/php/user/logout.php">
            <button type="submit" class="log_btns">로그아웃</button>
        </form>
        <?php else: ?>
            <form class="log_btn2" action="http://{도메인}/page/user/login.htm">
                <button type="submit" class="log_btns">로그인</button>
            </form>
        <?php endif; ?>
	</div>
</body>