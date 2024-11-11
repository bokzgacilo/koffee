
<?php
  session_start();
  
  if(!$_SESSION['adminauth']){
    header("location: login.php");
  }
?>

<?php require_once('../config.php'); ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>


<body
  class="sidebar-mini layout-fixed control-sidebar-slide-open layout-navbar-fixed sidebar-mini-md sidebar-mini-xs text-sm"
  data-new-gr-c-s-check-loaded="14.991.0" data-gr-ext-installed="" style="height: auto;">

  <style>
    .custom-toast {
      z-index: 50;
      position: fixed;
      bottom: 2%;
      right: 2%;
      background-color: #fff;
      padding: 1rem;
      display: none;
      place-items: center;
      border-radius: 4px;
      transform: translateX(100%); /* Start position (off the screen on the right) */
    }

    @keyframes slideInRight {
      0% {
        transform: translateX(100%); /* Start off-screen to the right */
        opacity: 0; /* Optional: Start with hidden opacity */
      }
      100% {
        transform: translateX(0); /* End in normal position */
        opacity: 1; /* Optional: Fade in */
      }
    }
    
    @keyframes slideToRight {
      0% {
        transform: translateX(0); /* Start off-screen to the right */
        opacity: 0; /* Optional: Start with hidden opacity */
      }
      100% {
        transform: translateX(10%0);
        opacity: 1; 
      }
    }

  </style>
  <div class="wrapper">
    <?php require_once('inc/topBarNav.php') ?>
    <?php require_once('inc/navigation.php') ?>
    <?php if ($_settings->chk_flashdata('success')): ?>
      <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
      </script>
    <?php endif; ?>
    <?php $page = isset($_GET['page']) ? $_GET['page'] : 'home'; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper  pt-3 pb-4" style="min-height: 567.854px;">

    <div class="custom-toast">
      <div class="custom-toast-body">
        <h6 class="mb-2">Order Received!</h6>
        <p>Please prepare new orders.</p>
        <a href="?page=sales" class="btn btn-primary btn-sm">Go To Orders</a>
      </div>
    </div>
      <!-- Main content -->
      <section class="content  text-dark">
        <div class="container-fluid">
          <?php
          if (!file_exists($page . ".php") && !is_dir($page)) {
            include '404.html';
          } else {
            if (is_dir($page))
              include $page . '/index.php';
            else
              include $page . '.php';

          }
          ?>
        </div>
      </section>
      <!-- /.content -->
      <div class="modal fade" id="confirm_modal" role='dialog'>
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Confirmation</h5>
            </div>
            <div class="modal-body">
              <div id="delete_content"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="uni_modal" role='dialog'>
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"></h5>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id='submit'
                onclick="$('#uni_modal form').submit()">Save</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="uni_modal_right" role='dialog'>
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="fa fa-arrow-right"></span>
              </button>
            </div>
            <div class="modal-body">
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="viewer_modal" role='dialog'>
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
            <img src="" alt="">
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-wrapper -->
    <?php require_once('inc/footer.php') ?>
</body>

</html>