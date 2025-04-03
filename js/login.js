function openPopup(){
	var si = document.bwl_f.sessionid;
	
	if(si.value==''){
		var popupURL = "http://localhost/page/user/login_popup.htm";

		var popupSet = "width=600,height=400,scrollbars=yes";
	
		window.open(popupURL, "Popup", popupSet);
	}
	else if(si.value != ''){
		window.location.href= "http://localhost/page/board/board_write.htm";
	}
}