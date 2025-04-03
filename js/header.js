function user_openPopup(){
	var si = document.ma_btn.sessionid;

	var popupURL = "http://localhost/page/user/user_popup.htm";

	var popupSet = "width=600,height=400,scrollbars=yes";

	window.open(popupURL, "Popup", popupSet);
}