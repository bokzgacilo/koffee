<?php
require_once('../config.php');
class Master extends DBConnection
{
	private $settings;
	public function __construct()
	{
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	function capture_err()
	{
		if (!$this->conn->error)
			return false;
		else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function delete_img()
	{
		extract($_POST);
		if (is_file($path)) {
			if (unlink($path)) {
				$resp['status'] = 'success';
			} else {
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete ' . $path;
			}
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown ' . $path . ' path';
		}
		return json_encode($resp);
	}
	function save_category()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!empty($data))
					$data .= ",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `category_list` where `name` = '{$name}' " . (!empty($id) ? " and id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Category Name already exists.";
			return json_encode($resp);
			exit;
		}
		if (empty($id)) {
			$sql = "INSERT INTO `category_list` set {$data} ";
		} else {
			$sql = "UPDATE `category_list` set {$data} where id = '{$id}' ";
		}
		$save = $this->conn->query($sql);
		if ($save) {
			$bid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if (empty($id))
				$resp['msg'] = "New Category successfully saved.";
			else
				$resp['msg'] = " Category successfully updated.";

		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		if ($resp['status'] == 'success')
			$this->settings->set_flashdata('success', $resp['msg']);
		return json_encode($resp);
	}
	function delete_category()
	{
		extract($_POST);
		$del = $this->conn->query("UPDATE `category_list` set `delete_flag` = 1 where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', " Category successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_product()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'old_image'))) {
				if (!empty($data))
					$data .= ",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}

		// Check for duplicate product names
		$check = $this->conn->query("SELECT * FROM `product_list` WHERE `name` = '{$name}' " . (!empty($id) ? " AND id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err()) {
			return $this->capture_err();
		}

		if ($check > 0) {
			$resp['status'] = 'failed';
			$resp['msg'] = "Product Name already exists.";
			return json_encode($resp);
			exit;
		}

		// Insert or update product
		if (empty($id)) {
			$sql = "INSERT INTO `product_list` SET {$data} ";
		} else {
			$sql = "UPDATE `product_list` SET {$data} WHERE id = '{$id}' ";
		}

		$save = $this->conn->query($sql);
		if ($save) {
			$pid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if (empty($id)) {
				$resp['msg'] = "New Product successfully saved.";
			} else {
				$resp['msg'] = "Product successfully updated.";
			}

			// Handle image upload
			if (!empty($_FILES['image']['tmp_name'])) {
				$dir = 'uploads/products/';
				$fullDir = base_app . $dir;

				// Ensure the directory exists
				if (!is_dir($fullDir)) {
					if (!mkdir($fullDir, 0755, true)) {
						$resp['status'] = 'failed';
						$resp['msg'] = "Failed to create directory.";
						return json_encode($resp);
					}
				}

				$fileName = !empty($old_image) ? $old_image : $_FILES['image']['name'];
				$filePath = $fullDir . $fileName;
				$accept = array('image/jpeg', 'image/png', 'image/webp');

				if (!in_array($_FILES['image']['type'], $accept)) {
					$resp['status'] = 'failed';
					$resp['msg'] = "Image file type is invalid";
					return json_encode($resp);
				} else {
					if (!move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
						$resp['status'] = 'failed';
						$resp['msg'] = "Failed to upload image.";
						return json_encode($resp);
					}
				}
			}

			// Set flash message for success
			$this->settings->set_flashdata('success', $resp['msg']);
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}

		return json_encode($resp);
	}


	function save_addon()
	{
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id'))) {
				if (!empty($data))
					$data .= ",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}

		$check = $this->conn->query("SELECT * FROM `addons` where `name` = '{$name}' " . (!empty($id) ? " and id != {$id} " : "") . " ")->num_rows;
		if ($this->capture_err())
			return $this->capture_err();
		// if ($check > 0) {
		// 	$resp['status'] = 'failed';
		// 	$resp['msg'] = "Addons Name already exists.";
		// 	echo json_encode($resp);
		// 	exit;
		// }
		if (empty($id)) {
			$sql = "INSERT INTO `addons` set {$data} ";
		} else {
			$sql = "UPDATE `addons` set {$data} where id = '{$id}' ";
		}

		$save = $this->conn->query($sql);
		if ($save) {
			$pid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			$resp['msg'] = empty($id) ? "New Addons successfully saved." : " Addons successfully updated.";
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}

		if ($resp['status'] == 'success')
			$this->settings->set_flashdata('success', $resp['msg']);

		echo json_encode($resp);
		exit;  // Ensure no extra data is sent
	}


	function delete_product()
	{
		extract($_POST);
		$del = $this->conn->query("UPDATE `product_list` set `delete_flag` = 1 where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', " Product successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function delete_addon()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `addons` WHERE id = '{$id}'");
		$resp = array(); // Initialize response array
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', " Addons successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		// Ensure proper JSON encoding
		header('Content-Type: application/json');
		echo json_encode($resp);
		exit(); // Ensure no additional output is sent
	}

	function save_sale()
	{
		if (empty($_POST['id'])) {
			$_POST['user_id'] = $this->settings->userdata('id');
			$prefix = date("Ymd");
			$code = sprintf("%'.04d", 1);
			while (true) {
				$check = $this->conn->query("SELECT * FROM `sale_list` where code = '{$prefix}{$code}' ")->num_rows;
				if ($check > 0) {
					$code = sprintf("%'.04d", abs($code) + 1);
				} else {
					$_POST['code'] = $prefix . $code;
					break;
				}
			}
		}
		extract($_POST);
		$data = "";
		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id')) && !is_array($_POST[$k])) {
				if (!empty($data))
					$data .= ",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if (empty($id)) {
			$sql = "INSERT INTO `sale_list` set {$data} ";
		} else {
			$sql = "UPDATE `sale_list` set {$data} where id = '{$id}' ";
		}
		$save = $this->conn->query($sql);
		if ($save) {
			$sid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['sid'] = $sid;
			$resp['status'] = 'success';
			if (empty($id))
				$resp['msg'] = "New Sale successfully saved.";
			else
				$resp['msg'] = " Sale successfully updated.";
			if (isset($product_id)) {
				$data = "";
				foreach ($product_id as $k => $v) {
					$pid = $v;
					$price = $this->conn->real_escape_string($product_price[$k]);
					$qty = $this->conn->real_escape_string($product_qty[$k]);
					if (!empty($data))
						$data .= ", ";
					$data .= "('{$sid}', '{$pid}', '{$qty}', '{$price}')";
				}
				if (!empty($data)) {
					$this->conn->query("DELETE FROM `sale_products` where sale_id = '{$sid}'");
					$sql_product = "INSERT INTO `sale_products` (`sale_id`, `product_id`,`qty`, `price`) VALUES {$data}";
					$save_products = $this->conn->query($sql_product);
					if (!$save_products) {
						$resp['status'] = 'failed';
						$resp['sql'] = $sql_product;
						$resp['error'] = $this->conn->error;
						if (empty($id)) {
							$resp['msg'] = "Sale Transaction has failed save.";
							$this->conn->query("DELETE FROM `sale_products` where sale_id = '{$sid}'");
						} else {
							$resp['msg'] = "Sale Transaction has failed update.";
						}
						return json_encode($resp);
					}
				}
			}
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		if ($resp['status'] == 'success')
			$this->settings->set_flashdata('success', $resp['msg']);
		return json_encode($resp);
	}
	function delete_sale()
	{
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `sale_list` where id = '{$id}'");
		if ($del) {
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', " Sale successfully deleted.");
		} else {
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function update_status()
	{
		extract($_POST);
		$update = $this->conn->query("UPDATE `sale_list` set `status` = '{$status}' where id = '{$id}'");
		if ($update) {
			$resp['status'] = 'success';
		} else {
			$resp['status'] = 'failed';
			$resp['msg'] = "sale's status has failed to update.";
		}
		if ($resp['status'] == 'success')
			$this->settings->set_flashdata('success', 'sale\'s Status has been updated successfully.');
		return json_encode($resp);
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'delete_img':
		echo $Master->delete_img();
		break;
	case 'save_category':
		echo $Master->save_category();
		break;
	case 'delete_category':
		echo $Master->delete_category();
		break;
	case 'save_addon':
		echo $Master->save_addon();
	case 'save_product':
		echo $Master->save_product();
		break;
	case 'delete_product':
		echo $Master->delete_product();
	case 'delete_addon':
		echo $Master->delete_addon();
		break;
	case 'save_sale':
		echo $Master->save_sale();
		break;
	case 'delete_sale':
		echo $Master->delete_sale();
		break;
	case 'update_status':
		echo $Master->update_status();
		break;
	default:
		// echo $sysset->index();
		break;
}