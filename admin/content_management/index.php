<style>
  .container-fluid {
    background-color: #fff;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .col-4 > img {
    width: 100%;
    height: 300px;
    object-fit: cover;
  }
</style>

<?php
  include("../api/connection.php");

  $c = $conn -> query("SELECT * FROM content_management WHERE id=1");
  
  $content = $c -> fetch_assoc();

  $conn -> close();
?>

<div class="container-fluid">
  <h1>Content Management</h1>
  <form id="contentManagementForm" class="d-flex flex-column" enctype="multipart/form-data">
    
    <div class="row">
      <?php
        $banners = json_decode($content['banner'], true);

        foreach ($banners as $banner) {
          echo "
          <div class='col-4'>
            <h4>Banner ".$banner['id']."</h4>
            <img src='../".$banner['image']."' id='banner".$banner['id']."' class='mb-4' />
            <h5>Change Picture</h5>
            <input accept='image/*' type='file' name='bannerImage".$banner['id']."' id='bannerImage".$banner['id']."' class='form-control mb-4' />
            <h5>Banner Title</h5>
            <input value='".$banner['title']."' type='text' name=bannerTitle".$banner['id']." id='bannerTitle".$banner['id']."' class='form-control mb-4' required />
            <h5>Banner Description</h5>
            <input value='".$banner['description']."' type='text' name='bannerDescription".$banner['id']."' id='bannerDescription".$banner['id']."' class='form-control mb-4' required />
          </div>
          ";
        }
      ?>
    </div>
    <div class="row">
      <?php
        $descriptions = json_decode($content['description'], true);

        foreach ($descriptions as $desc) {
          echo "
          <div class='col-4'>
            <h4>Description</h4>
            <img src='../".$desc['image']."' id='desc".$desc['id']."' class='mb-4' />
            <h5>Change Picture</h5>
            <input accept='image/*' type='file' name='descImage".$desc['id']."' id='descImage".$desc['id']."' class='form-control mb-4' />
            <h5>Title</h5>
            <input value='".$desc['title']."' type='text' name=descTitle".$desc['id']." id='descTitle".$banner['id']."' class='form-control mb-4' required />
            <h5>Description</h5>
            <input value='".$desc['description']."' type='text' name='descDescription".$desc['id']."' id='descDescription".$banner['id']."' class='form-control mb-4' required />
          </div>
          ";
        }
      ?>

      <?php
        $abouts = json_decode($content['about'], true);

        foreach ($abouts as $about) {
          echo "
          <div class='col-4'>
            <h4>About</h4>
            <img src='../".$about['image']."' id='about".$about['id']."' class='mb-4' />
            <h5>Change Picture</h5>
            <input accept='image/*' type='file' name='aboutImage' id='aboutImage".$about['id']."' class='form-control mb-4' />
            <h5>Title</h5>
            <input value='".$about['title']."' type='text' name='aboutTitle' id='aboutTitle".$about['id']."' class='form-control mb-4' required />
            <h5>Description</h5>
            <input value='".$about['description']."' type='text' name='aboutDescription' id='aboutDescription".$about['id']."' class='form-control mb-4' required />
          </div>
          ";
        }
      ?>
      <?php
        echo "
        <div class='col-4'>
          <h4>Gcash</h4>
          <img src='../".$content['gcash']."' id='gcash' class='mb-4' />
          <h5>Change Picture</h5>
          <input accept='image/*' type='file' name='gcashImage' id='gcashImage' class='form-control mb-4' />
        </div>
        ";
      ?>
    </div>
    <div class="row">
      <?php
        echo "
        <div class='col-4'>
          <h4>Contact</h4>
          <h5>Phone</h5>
          <input value='".$content['phone']."' type='text' name='phone' class='form-control mb-4' required />
          <h5>Email</h5>
          <input value='".$content['email']."' type='text' name='email' class='form-control mb-4' required />
          <h5>Address</h5>
          <input value='".$content['address']."' type='text' name='address' class='form-control mb-4' required />
        </div>
        ";
      ?>
    </div>
    <div class="row">
      <div class="col-12">
        <h4>Terms and Condition</h4>
        <div id="editor-container" style="height: 200px;"></div>
        <textarea name="quill" id="quill" style="display: none;"></textarea>
      </div>
    </div>
    <div>
    <button class="mt-4 btn btn-primary btn-lg" type="submit">Save Changes</button>
    </div>
  </form>
</div>
<script>
    // Initialize Quill editor
    var quill = new Quill('#editor-container', {
        theme: 'snow',
        modules: {
            toolbar: [
              [{ 'header': [1, 2, false] }],
              ['bold', 'italic', 'underline'],
              [{ 'list': 'ordered' }, { 'list': 'bullet' }],
              ['link']
            ]
        }
    });

    var initialContent = `<?php echo addslashes($content['terms_and_condition']); ?>`;  // Escaping for JS
    quill.root.innerHTML = initialContent;

    // Capture content in hidden textarea on form submit
    document.querySelector('form').onsubmit = function() {
        var content = document.querySelector('textarea[name=quill]');
        content.value = quill.root.innerHTML;
    };
</script>
<script>
  $(document).ready(function(){
    $("#bannerImage1").on('change', function(event){
      var file = event.target.files[0];
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $('#banner1').attr('src', e.target.result);
      };

      if (file) {
        reader.readAsDataURL(file);
      }
    })

    $("#bannerImage2").on('change', function(event){
      var file = event.target.files[0];
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $('#banner2').attr('src', e.target.result);
      };

      if (file) {
        reader.readAsDataURL(file);
      }
    })

    $("#bannerImage3").on('change', function(event){
      var file = event.target.files[0];
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $('#banner3').attr('src', e.target.result);
      };

      if (file) {
        reader.readAsDataURL(file);
      }
    })

    $("#descImage1").on('change', function(event){
      var file = event.target.files[0];
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $('#desc1').attr('src', e.target.result);
      };

      if (file) {
        reader.readAsDataURL(file);
      }
    })

    $("#aboutImage1").on('change', function(event){
      var file = event.target.files[0];
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $('#about1').attr('src', e.target.result);
      };

      if (file) {
        reader.readAsDataURL(file);
      }
    })

    $("#gcashImage").on('change', function(event){
      var file = event.target.files[0];
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $('#gcash').attr('src', e.target.result);
      };

      if (file) {
        reader.readAsDataURL(file);
      }
    })

    $("#contentManagementForm").on("submit", function(event){
      event.preventDefault();

      var formData = new FormData(this);

      console.log(formData);
      $.ajax({
        type: "post",
        url : "../api/post_edit_content_management.php",
        contentType: false,
        processData: false,
        data: formData,
        success: response => {
          if(response === "ok"){
            alert('Homepage contents updated');

            location.reload();
          }
        }
      })
    })
  })
</script>