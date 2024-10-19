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
	<form id="product-form" enctype="multipart/form-data">
		<div class="form-group">
			<label for="category_id" class="control-label">Category</label>
			<select name="category_id" id="category_id" class="form-control form-control-sm rounded-0" required>
        <?php
          $category = $conn -> query("SELECT * FROM category_list");

          while($row = $category -> fetch_assoc()){
            echo "<option value='".$row['id']."'>".$row['name']."</option>";
          }
        ?>
			</select>
		</div>
		<div class="form-group">
			<label for="name" class="control-label">Name</label>
			<input type="text" name="name" id="name" class="form-control" required />
		</div>
		<div class="form-group">
			<label for="description" class="control-label">Description</label>
			<textarea name="description" id="description" class="form-control" required></textarea>
		</div>
		<div class="form-group">
			<label for="price" class="control-label">Price</label>
			<input type="number" name="price" id="price" class="form-control" required />
		</div>
		<div class="form-group">
			<label for="price" class="control-label">Has Size?</label>
			<div class="row">
        <div class='col-6'>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="hasSizeRadio" id="sizeYes" check>
            <label class="form-check-label" for="sizeYes">
              Yes
            </label>
          </div>
        </div>
        <div class='col-6'>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="hasSizeRadio" id="sizeNo">
            <label class="form-check-label" for="sizeNo">
              No
            </label>
          </div>
        </div>
      </div>
		</div>
		<div class="form-group">
			<select hidden name="status" id="status" class="form-control" required>
				<option value="1">Active</option>
				<option value="0">Inactive</option>
			</select>
		</div>
		<div class="form-group">
			<label for="image" class="control-label">Image</label>
			<input type="file" name="image" id="image" class="form-control" required/>
      <img id="uploadedImage" class="img-fluid" src="" />
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
    $('input[name="hasSizeRadio"]').change(function(){
      var selectedvalue = $('input[name="hasSizeRadio"]:checked').next('label').text();

      console.log("Selected: " + selectedValue);
    })

		// $('#uni_modal').on('shown.bs.modal', function () {
		// 	$('#category_id').select2({
		// 		placeholder: "Please select here",
		// 		width: '100%',
		// 		dropdownParent: $('#uni_modal'),
		// 		containerCssClass: 'form-control form-control-sm rounded-0'
		// 	});
		// });

    $('#product-form').on("submit", function(e){
      e.preventDefault();

      var formData = new FormData($('#product-form')[0]); // Get the form data including file upload

      $.ajax({
        url: '../api/post_add_product.php', // The PHP script that handles the form submission
        type: 'POST',
        data: formData,
        contentType: false,  // Necessary for file upload
        processData: false,  // Necessary for file upload
        success: function (response) {
          console.log(response)
        }
      });

      // alert();
    })
		// $('#product-form').submit(function (e) {
		// 	e.preventDefault();
		// 	var _this = $(this);
		// 	$('.err-msg').remove();
		// 	start_loader();
		// 	$.ajax({
		// 		url: _base_url_ + "classes/Master.php?f=save_product",
		// 		data: new FormData($(this)[0]),
		// 		cache: false,
		// 		contentType: false,
		// 		processData: false,
		// 		method: 'POST',
		// 		type: 'POST',
		// 		dataType: 'json',
		// 		error: err => {
		// 			console.log(err);
		// 			alert_toast("An error occurred", 'error');
		// 			end_loader();
		// 		},
		// 		success: function (resp) {
		// 			if (typeof resp == 'object' && resp.status == 'success') {
		// 				location.reload();
		// 			} else if (resp.status == 'failed' && !!resp.msg) {
		// 				var el = $('<div>');
		// 				el.addClass("alert alert-danger err-msg").text(resp.msg);
		// 				_this.prepend(el);
		// 				el.show('slow');
		// 				$("html, body,.modal").scrollTop(0);
		// 				end_loader();
		// 			} else {
		// 				alert_toast("An error occurred", 'error');
		// 				end_loader();
		// 			}
		// 		}
		// 	});
		// });
	});
</script>