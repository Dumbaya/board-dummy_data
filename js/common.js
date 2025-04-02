const register_check = () => {
	const userid = document.register_form.user_id;
	const user_email = document.register_form.user_email;

	if((/\D/).test(userid.value)==false){
		alert("아이디에 영문자를 넣어주세요.");
		userid.focus();
		userid.value='';
		return false;
	}

	if((/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i).test(user_email.value)==false){
		alert("이메일을 확인해주세요.");
		user_email.focus();
		user_email.value='';
		return false;
	}
}

const boardcomment_check = () => {
	const boardcomment = document.board_comment_form.board_comment;

	if(boardcomment.value==''){
		alert("댓글을 작성해주세요.");
		boardcomment.focus();
		return false;
	}
}

