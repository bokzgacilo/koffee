<?php
  include("../../api/connection.php");

  $productid = $_GET['id'];

  $getproduct = $conn -> query("SELECT * FROM product_list WHERE id=$productid");
  $product = $getproduct -> fetch_assoc();
?>

<div class="container-fluid">
	<form id="product-form" enctype="multipart/form-data">
    <input type="hidden" name="productid" value="<?php echo $productid; ?>" />
		<div class="form-group">
			<label for="category_id" class="control-label">Category</label>
			<select disabled name="category_id" id="category_id" class="form-control form-control-sm rounded-0" required>
        <?php 
          $categoryid = $product['category_id'];
          $getcategoryname = $conn -> query("SELECT name FROM category_list WHERE id=$categoryid");
          $category = $getcategoryname -> fetch_assoc();

          echo "
            <option value='$categoryid'>".$category['name']."</option>
          ";
        ?>
			</select>
		</div>
		<div class="form-group">
			<label for="name" class="control-label">Name</label>
			<input value="<?php echo $product['name']; ?>" type="text" name="name" id="name" class="form-control" required />
		</div>
		<div class="form-group">
			<label for="description" class="control-label">Description</label>
			<textarea name="description" id="description" class="form-control" required><?php echo $product['description']; ?></textarea>
		</div>
		<div class="form-group">
			<label for="price" class="control-label">Price</label>
			<input value="<?php echo $product['price']; ?>" type="number" name="price" id="price" class="form-control" required />
		</div>
    <div class="form-group">
      <label for="status" class="control-label">Status</label>
			<select name="status" id="status" class="form-control" required>
				<option value="1">Active</option>
				<option value="0">Inactive</option>
			</select>
		</div>
		<!-- <div class="form-group">
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
		</div> -->
		<!-- <div id="sizeSetter" style="display: none;" class="flex-column form-group">
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
		</div> -->
		<!-- <div class="form-group">
			<select hidden name="status" id="status" class="form-control" required>
				<option value="1">Active</option>
				<option value="0">Inactive</option>
			</select>
		</div> -->
		<div class="form-group mt-4">
			<label for="image" class="control-label">Image</label>
			<input type="file" name="image" id="image" class="form-control" required/>
      <img id="uploadedImage" class="img-fluid" src="../<?php echo $product['image_url']; ?>" />
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

  $(document).ready(function(){
    $('#product-form').on("submit", function(e){
      e.preventDefault();

      var formData = new FormData($('#product-form')[0]);

      $.ajax({
        url: '../api/post_edit_product.php', // The PHP script that handles the form submission
        type: 'POST',
        data: formData,
        contentType: false, 
        processData: false, 
        success: function (response) {
          if(response === "ok"){
            alert('Product edited successfully')

            location.reload();
            // Swal.fire({
            //   title: "Product Edited",
            //   text: "Product edited successfully",
            //   icon: "success"
            // });
          }
        }
      });
    })
  })
</script>