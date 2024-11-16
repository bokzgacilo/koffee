<?php
session_start();
require_once('../config.php');
Class Users extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}

	public function __destruct(){
		parent::__destruct();
	}

	public function save_users(){
    $adminid = $_SESSION['adminid'];
    $userExists = false;

    if ($adminid) {
      $result = $this->conn->query("SELECT 1 FROM users WHERE id = $adminid LIMIT 1");
      if ($result && $result->num_rows > 0) {
          $userExists = true;
      }
    }

		if(empty($_POST['password'])){
			unset($_POST['password']);
    }else {
      $_POST['password'] = $_POST['password'];
    }

    extract($_POST);

		$data = '';

		foreach($_POST as $k => $v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=" , ";
				$data .= " {$k} = '{$v}' ";
			}
		}

    if ($userExists) {
      $qry = $this->conn->query("UPDATE users set $data where id = $adminid");
      
			if($qry){
				$this->settings->set_flashdata('success','User Details successfully updated.');
				foreach($_POST as $k => $v){
					if($k != 'id'){
						if(!empty($data)) $data .=" , ";
						if($this->settings->userdata('id') == $adminid)
							$this->settings->set_userdata($k,$v);
					}
				}

        $image_url = "";
        
				if(!empty($_FILES['img']['tmp_name'])){
          $fileTmpPath = $_FILES['img']['tmp_name'];
          $originalFileName = $_FILES['img']['name'];
          $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
          $newFileName = $adminid . '.' . $fileExtension;

					$target_file = "../uploads/avatars/$newFileName";

          if (move_uploaded_file($fileTmpPath, $target_file)) {
            $image_url = "/uploads/avatars/" . $newFileName;
            $this->conn->query("UPDATE `users` set `avatar` = '$image_url' where id = $adminid");
          } else {
            echo "Error moving the uploaded file.";
          }
				}
        
        $_SESSION['adminavatar'] = $image_url;
				return 1;
      }else {
        if($this -> conn -> query("UPDATE users set $data where id = $adminid")){
          return 1;
        }
      }
    } else {
      $qry = $this->conn->query("INSERT INTO users set {$data}");

			if($qry){
				$id=$this->conn->insert_id;
				$this->settings->set_flashdata('success','User Details successfully saved.');

				foreach($_POST as $k => $v){
					if($k != 'id'){
						if(!empty($data)) $data .=" , ";
						if($this->settings->userdata('id') == $id)
						$this->settings->set_userdata($k,$v);
					}
				}

				if(!empty($_FILES['img']['tmp_name'])){
					if(!is_dir(base_app."uploads/avatars"))
						mkdir(base_app."uploads/avatars");
					$ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
					$fname = "uploads/avatars/$id.png";
					$accept = array('image/jpeg','image/png');
					if(!in_array($_FILES['img']['type'],$accept)){
						$err = "Image file type is invalid";
					}
					if($_FILES['img']['type'] == 'image/jpeg')
						$uploadfile = imagecreatefromjpeg($_FILES['img']['tmp_name']);
					elseif($_FILES['img']['type'] == 'image/png')
						$uploadfile = imagecreatefrompng($_FILES['img']['tmp_name']);
					if(!$uploadfile){
						$err = "Image is invalid";
					}
					$temp = imagescale($uploadfile,200,200);
					if(is_file(base_app.$fname))
					unlink(base_app.$fname);
					$upload =imagepng($temp,base_app.$fname);
					if($upload){
						$this->conn->query("UPDATE `users` set `avatar` = CONCAT('{$fname}', '?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$id}'");
						if($this->settings->userdata('id') == $id)
						$this->settings->set_userdata('avatar',$fname."?v=".time());
					}

					imagedestroy($temp);
				}

				return 1;
    }
		}
	}
	public function delete_users(){
		extract($_POST);
		$qry = $this->conn->query("DELETE FROM users where id = $id");
		if($qry){
			$this->settings->set_flashdata('success','User Details successfully deleted.');
			if(is_file(base_app."uploads/avatars/$id.png"))
				unlink(base_app."uploads/avatars/$id.png");
			return 1;
		}else{
			return false;
		}
	}
	
}

$users = new users();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
	case 'save':
		echo $users->save_users();
	break;
	case 'delete':
		echo $users->delete_users();
	break;
	default:
		// echo $sysset->index();
		break;
}