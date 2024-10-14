<h1>Welcome to <?php echo $_settings->info('name') ?></h1>
<hr>
<div class="row">
  <div class="col-12 col-sm-4 col-md-4">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-light elevation-1"><i class="fas fa-th-list"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Users List</span>
        <span class="info-box-number text-right">
          <?php
          $category = $conn->query("SELECT * FROM users where type = 2")->num_rows;
          echo format_num($category);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <div class="col-12 col-sm-4 col-md-4">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-navy elevation-1"><i class="fas fa-mug-hot"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Products List</span>
        <span class="info-box-number text-right">
          <?php
          $product = $conn->query("SELECT * FROM product_list where delete_flag = 0 and `status` = 1")->num_rows;
          echo format_num($product);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-4 col-md-4">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-calendar-day"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Today's Sales</span>
        <span class="info-box-number text-right">
          <?php
          if ($_settings->userdata('type') == 3):
            $total = $conn->query("SELECT sum(price) as total FROM orders where client_id = '{$_settings->userdata('id')}' ");
          else:
            $total = $conn->query("SELECT sum(price) as total FROM orders");
          endif;
          $total = $total->num_rows > 0 ? $total->fetch_array()['total'] : 0;
          $total = $total > 0 ? $total : 0;
          echo format_num($total);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
</div>

<?php if ($_settings->chk_flashdata('success')): ?>
  <script>
    alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
  </script>
<?php endif; ?>
<div class="card card-outline rounded-0 card-navy">
  <div class="card-header">
    <h3 class="card-title">List of Sales</h3>
    <div class="card-tools">
      <a href="./?page=sales/manage_sale" id="create_new" class="btn btn-flat btn-primary"><span
          class="fas fa-plus"></span> Create New</a>
    </div>
  </div>
  <div class="card-body">
    <div class="container-fluid">
      <div class="container-fluid">
        <table class="table table-hover table-striped table-bordered">
          <colgroup>
            <col width="5%">
            <col width="20%">
            <col width="20%">
            <col width="25%">
            <col width="15%">
            <col width="15%">
          </colgroup>
          <thead>
            <tr>
              <th>#</th>
              <th>Date Updated</th>
              <th>Code</th>
              <th>Customer</th>
              <th>Amount</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = 1;
            if ($_settings->userdata('type') == 3):
              $qry = $conn->query("SELECT * FROM `orders` where client_id = '{$_settings->userdata('id')}' order by unix_timestamp(date_updated) desc ");
            else:
              $qry = $conn->query("SELECT * FROM `orders` order by unix_timestamp(order_date) desc ");
            endif;
            while ($row = $qry->fetch_assoc()):
              ?>
              <tr>
                <td class="text-center"><?php echo $i++; ?></td>
                <td>
                  <p class="m-0 truncate-1"><?= date("M d, Y H:i", strtotime($row['order_date'])) ?></p>
                </td>
                <td>
                  <p class="m-0 truncate-1"><?= $row['reference_number'] ?></p>
                </td>
                <td>
                  <p class="m-0 truncate-1"><?=
                    $clientid = $row['client_id'];
                    $getName = $conn -> query("SELECT * FROM users WHERE id=$clientid");
                    while($get = $getName -> fetch_assoc()){
                      echo $get['lastname'] . ", " . $get['firstname'];
                    }
                  ?></p>
                </td>
                <td class='text-right'><?= format_num($row['price']) ?></td>
                <td align="center">
                  <a class="btn btn-default bg-gradient-light btn-flat btn-sm"
                    href="?page=sales/view_details&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span>
                    View</a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function () {

    $('.table').dataTable({
      columnDefs: [
        { orderable: false, targets: [5] }
      ],
      order: [0, 'asc']
    });
    $('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
  })

</script>