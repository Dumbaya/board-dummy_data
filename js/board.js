function comment_upd_openPopup(tmp_num_mb, t_bcid){
	var tmp_bcid = t_bcid;
	var tmp_num_mb = tmp_num_mb;

	var popupURL = "http://localhost/page/board/board_comment_update.htm?bcid="+tmp_bcid+"&tmp_num="+tmp_num_mb;

	var popupSet = "width=600,height=400,scrollbars=yes";

	window.open(popupURL, "Popup", popupSet);
}

function ccomment_write_openPopup(tmp_num_mb, t_bcid, t_group){
	var tmp_bcid = t_bcid;
	var tmp_num_mb = tmp_num_mb;
	var tmp_group = t_group;
	
	var popupURL = "http://localhost/page/board/board_ccomment_write.htm?bcid="+tmp_bcid+"&tmp_num="+tmp_num_mb+"&group_id="+tmp_group;

	var popupSet = "width=600,height=400,scrollbars=yes";

	window.open(popupURL, "Popup", popupSet);
}