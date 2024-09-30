<?php

require_once('../../config.php');

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id > 0) {
	$qry = $conn->query("SELECT * FROM `product_list` WHERE id = '{$id}'");
	if ($qry->num_rows > 0) {
		$data = $qry->fetch_assoc();
		foreach ($data as $k => $v) {
			$$k = $v;
		}
	}
}
?>
<div class="container-fluid">
	<form action="" id="product-form" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php echo isset($id) ? htmlspecialchars($id) : '' ?>">
		<div class="form-group">
			<label for="category_id" class="control-label">Category</label>
			<select name="category_id" id="category_id" class="form-control form-control-sm rounded-0" required>
				<option value="" disabled <?= !isset($category_id) ? "selected" : "" ?>></option>
				<?php
				$qry = $conn->query("SELECT * FROM category_list WHERE delete_flag = 0 AND status = 1 " . (isset($category_id) ? " OR id = '{$category_id}' " : "") . " ORDER BY name ASC");
				while ($row = $qry->fetch_array()):
					?>
					<option value="<?= htmlspecialchars($row['id']) ?>" <?php echo isset($category_id) && $category_id == $row['id'] ? 'selected' : '' ?>><?= htmlspecialchars($row['name']) ?></option>
				<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group">
			<label for="name" class="control-label">Name</label>
			<input type="text" name="name" id="name" class="form-control form-control-sm rounded-0"
				value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" required />
		</div>
		<div class="form-group">
			<label for="description" class="control-label">Description</label>
			<textarea name="description" id="description" class="form-control form-control-sm rounded-0"
				required><?php echo isset($description) ? htmlspecialchars($description) : ''; ?></textarea>
		</div>
		<div class="form-group">
			<label for="price" class="control-label">Price</label>
			<input type="number" name="price" id="price" class="form-control form-control-sm rounded-0 text-right"
				value="<?php echo isset($price) ? htmlspecialchars($price) : ''; ?>" required />
		</div>
		<div class="form-group">
			<label for="status" class="control-label">Status</label>
			<select name="status" id="status" class="form-control form-control-sm rounded-0" required>
				<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
				<option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
			</select>
		</div>
		<div class="form-group">
			<label for="image" class="control-label">Image</label>
			<input type="file" name="image" id="image" class="form-control form-control-sm rounded-0" />
			<?php
			$formattedDate = isset($date_created) ? str_replace([':', ' ', '.png'], ['-', '_', ''], $date_created) : '';
			?>
			<input hidden name="old_image" id="old_image"
				value="<?php echo isset($formattedDate) ? htmlspecialchars($formattedDate) . '.png' : ''; ?>" />
			<div class="mt-2">

				<img id="uploadedImage" class="img-fluid"
					src="../uploads/products/<?php echo htmlspecialchars($formattedDate); ?>.png"
					alt="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" />
			</div>
		</div>
	</form>
</div>
<script>
	document.getElementById('image').addEventListener('change', function (event) {
		var file = event.target.files[0];
		var reader = new FileReader();
		reader.onload = function (e) {
			var img = document.getElementById('uploadedImage');
			img.src = e.target.result;
		};
		if (file) {
			reader.readAsDataURL(file);
		}
	});

	$(document).ready(function () {
		$('#uni_modal').on('shown.bs.modal', function () {
			$('#category_id').select2({
				placeholder: "Please select here",
				width: '100%',
				dropdownParent: $('#uni_modal'),
				containerCssClass: 'form-control form-control-sm rounded-0'
			});
		});

		$('#product-form').submit(function (e) {
			e.preventDefault();
			var _this = $(this);
			$('.err-msg').remove();
			start_loader();
			$.ajax({
				url: _base_url_ + "classes/Master.php?f=save_product",
				data: new FormData($(this)[0]),
				cache: false,
				contentType: false,
				processData: false,
				method: 'POST',
				type: 'POST',
				dataType: 'json',
				error: err => {
					console.log(err);
					alert_toast("An error occurred", 'error');
					end_loader();
				},
				success: function (resp) {
					if (typeof resp == 'object' && resp.status == 'success') {
						location.reload();
					} else if (resp.status == 'failed' && !!resp.msg) {
						var el = $('<div>');
						el.addClass("alert alert-danger err-msg").text(resp.msg);
						_this.prepend(el);
						el.show('slow');
						$("html, body,.modal").scrollTop(0);
						end_loader();
					} else {
						alert_toast("An error occurred", 'error');
						end_loader();
					}
				}
			});
		});
	});
</script>