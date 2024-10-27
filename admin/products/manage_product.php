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
            <input class="form-check-input" type="radio" name="sizeRadio" value="1" check>
            <label class="form-check-label">
              Yes
            </label>
          </div>
        </div>
        <div class='col-6'>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="sizeRadio" value="0">
            <label class="form-check-label">
              No
            </label>
          </div>
        </div>
      </div>
		</div>
		<div id="sizeSetter" style="display: none;" class="flex-column form-group">
			<label for="price" class="control-label">Size List</label>
			<div class="row mb-2">
        <div class="col-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="size[]" value="small">
            <label class="form-check-label" for="flexCheckDefault">
              Small
            </label>
          </div>
        </div>
        <div class="col-9">
          <input type="number" name="small_price" class="form-control-sm form-control" disabled />
        </div>
      </div>
			<div class="row mb-2">
        <div class="col-3">
          <div class="form-check">
            <input class="form-check-input" name="size[]" type="checkbox" value="regular">
            <label class="form-check-label" for="flexCheckDefault">
              Regular
            </label>
          </div>
        </div>
        <div class="col-9">
          <input type="number" name="regular_price" class="form-control-sm form-control" disabled />
        </div>
      </div>
			<div class="row mb-2">
        <div class="col-3">
          <div class="form-check">
            <input class="form-check-input" name="size[]" type="checkbox" value="large">
            <label class="form-check-label" for="flexCheckDefault">
              Large
            </label>
          </div>
        </div>
        <div class="col-9">
          <input type="number" name="large_price" class="form-control form-control-sm" disabled />
        </div>
      </div>
		</div>
		<div class="form-group">
			<select name="status" id="status" class="form-control" required>
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
    $('input[type="checkbox"]').change(function(){
      var checkedValues = [];

      $('input[type="checkbox"]').each(function() {
        checkedValues.push($(this).val());
        var sizeValue = $(this).val();

        var priceInput = $('input[name="'+sizeValue + '_price"]');

        if ($(this).is(':checked')) {
          priceInput.removeAttr('disabled');
          priceInput.attr('value', 10); 
        } else {
          priceInput.attr('disabled', true); 
          priceInput.removeAttr('value');
          priceInput.val('');
        }
      });

      console.log("Checked sizes: " + checkedValues.join(", "));
    })

    $('input[name="sizeRadio"]').change(function(){
      var selectedValue = $('input[name="sizeRadio"]:checked').val();

      if(selectedValue === "1"){
        $("#sizeSetter").css({'display' : 'flex'})
      }
      
      if(selectedValue === "0") {
        $("#sizeSetter").css({'display' : 'none'})
      }
    })

    $('#product-form').on("submit", function(e){
      e.preventDefault();

      var formData = new FormData($('#product-form')[0]);

      $.ajax({
        url: '../api/post_add_product.php', // The PHP script that handles the form submission
        type: 'POST',
        data: formData,
        contentType: false, 
        processData: false, 
        success: function (response) {
          if(response === "ok"){
            Swal.fire({
              title: "Product Added",
              text: "Product created successfully",
              icon: "success"
            });
          }else {
            Swal.fire({
              title: "Product already exsiting",
              text: "Product name already existing",
              icon: "error"
            });
          }
        }
      });
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