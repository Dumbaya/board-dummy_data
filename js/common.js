const register_check = () => {
	const userid = document.register_form.user_id;
	const user_email = document.register_form.user_email;

	if((/\D/).test(userid.value)==false){
		alert("���̵� �����ڸ� �־��ּ���.");
		userid.focus();
		userid.value='';
		return false;
	}

	if((/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i).test(user_email.value)==false){
		alert("�̸����� Ȯ�����ּ���.");
		user_email.focus();
		user_email.value='';
		return false;
	}
}

const boardcomment_check = () => {
	const boardcomment = document.board_comment_form.board_comment;

	if(boardcomment.value==''){
		alert("����� �ۼ����ּ���.");
		boardcomment.focus();
		return false;
	}
}

