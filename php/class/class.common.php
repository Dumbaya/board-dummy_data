<?php
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/class/DB.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/php/session.php');

	class common{
		private $secret_key = "study_board_secret_key";
		
		function aes128_encode($password){
			$enc_password = base64_encode(openssl_encrypt($password, "AES-128-CBC", $this->secret_key, false));

			return $enc_password;
		}

		function sha256_encode($password){
			$enc_password = hash('sha256', $password);

			return $enc_password;
		}

		function setSession($user_id, $user_nickname, $user_role){
			$_SESSION['user_id'] = $user_id;
			$_SESSION['user_nickname'] = $user_nickname;
			$_SESSION['user_role'] = $user_role;
		}

		function setimg_path($img_name, $dir_path){
			if(isset($_FILES[$img_name]) && $_FILES[$img_name]['error'] === UPLOAD_ERR_OK){
				$uploadDir = rtrim($dir_path, '/') . '/';
				if(!is_dir($uploadDir)){
					mkdir($uploadDir, 0777, true);
				}
				$imageFileType = strtolower(pathinfo($_FILES[$img_name]['name'], PATHINFO_EXTENSION));
				$allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
				if(in_array($imageFileType, $allowedTypes)){
					$timestamp = round(microtime(true) * 1000);
					$newFileName = date("Ymd_His", $timestamp / 1000) . "_$timestamp.$imageFileType";
					$targetFilePath = $uploadDir.$newFileName;
					if(move_uploaded_file($_FILES[$img_name]['tmp_name'], $targetFilePath)){
						return $targetFilePath;
					}
					else{
						echo "<script>alert('���� ���ε� �� ������ �߻��߽��ϴ�.2');</script>";
						echo "<script>window.history.back();</script>";
						return false;
					}
				}
				else{
					echo "<script>alert('�������� �ʴ� ���� �����Դϴ�.');</script>";
					echo "<script>window.history.back();</script>";
					return false;
				}
			}
			else{
				return '';
			}
		}		

		/*
		* mode
		* 1 == board
		* 2 == bonoga
		*/
		function getWhere($condition, $for_search, $mode=1){
			$search = addslashes($for_search);

			if($mode==1){
				switch($condition){
					case 1://����
						return "where board_title like '%$search%'";
					case 2://�ۼ���
						return "where board_writer like '%$search%'";
					case 3://����
						return "where board_body like '%$search%'";
					case 4://����+����
						return "where board_title like '%$search%' or board_body like '%$search%'";
				}
			}
			else if($mode==2){
				switch($condition){
					case 1://����
						return "where img_title like '%$search%'";
					case 2://�ۼ���
						return "where img_writer like '%$search%'";
				}
			}
			else if($mode==3){
				switch($condition){
					case 1://����
						return " and dl_title like '%$search%'";
					case 2://����
						return " and dl_body like '%$search%'";
					case 3://����+����
						return " and dl_title like '%$search%' or dl_body like '%$search%'";
				}
			}
			else if($mode==4){
				switch($condition){
					case 1://����
						return "and board_title like '%$search%'";
					case 2://�ۼ���
						return "and board_writer like '%$search%'";
					case 3://����
						return "and board_body like '%$search%'";
					case 4://����+����
						return "and board_title like '%$search%' or board_body like '%$search%'";
				}
			}
			else if($mode==5){
				return "and bc_comment like '%$search%'";
			}
		}
	}
?>