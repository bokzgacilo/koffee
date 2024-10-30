<h1 class="mt-4 mb-4">Kofee Manila - Overview</h1>

<style>
  .custom-card {
    background-color: #fff;
    padding: 2rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    border-radius: 4px;
  }

  .custom-card-header {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
  }
</style>

<div class="row">
  <div class="col-3">
    <div class="custom-card">
      <div class="custom-card-header">
        <h4>Registered Users</h4>
        <h4>
          <?php
          $users = $conn -> query("SELECT * FROM users where type = 2") -> num_rows;
          echo format_num($users);
          ?>
        </h4>
      </div>
      <div class="custom-card-body">
        <a href="?page=user/list" class="w-100 btn btn-primary">Manage Users</a>
      </div>
    </div>
  </div>
  <div class="col-3">
    <div class="custom-card">
      <div class="custom-card-header">
        <h4>Products</h4>
        <h4>
          <?php
          $products = $conn -> query("SELECT * FROM product_list ") -> num_rows;
          echo format_num($products);
          ?>
        </h4>
      </div>
      <div class="custom-card-body">
        <a href="?page=products" class="w-100 btn btn-primary">Manage Products</a>
      </div>
    </div>
  </div>
  <div class="col-3">
    <div class="custom-card">
      <div class="custom-card-header">
        <h4>Categories</h4>
        <h4>
          <?php
          $products = $conn -> query("SELECT * FROM category_list ") -> num_rows;
          echo format_num($products);
          ?>
        </h4>
      </div>
      <div class="custom-card-body">
        <a href="?page=categories" class="w-100 btn btn-primary">Manage Categories</a>
      </div>
    </div>
  </div>
  <div class="col-3">
    <div class="custom-card">
      <div class="custom-card-header">
        <h4>Addons</h4>
        <h4>
          <?php
            $addons = $conn -> query("SELECT * FROM addons") -> num_rows;
            echo format_num($addons);
            ?>
        </h4>
      </div>
      <div class="custom-card-body">
        <a href="?page=addons" class="w-100 btn btn-primary">Manage Addons</a>
      </div>
    </div>
  </div>
</div>

<div class="row mt-4">
  <div class="col-3">
    <div class="custom-card">
      <div class="custom-card-header">
        <h4>Submitted Feedbacks</h4>
        <h4>
          <?php
          $feedbacks = $conn -> query("SELECT * FROM customer_feedback") -> num_rows;
          echo format_num($feedbacks);
          ?>
        </h4>
      </div>
      <div class="custom-card-body">
        <a href="?page=feedbacks" class="w-100 btn btn-primary">Manage Feedbacks</a>
      </div>
    </div>
  </div>
  <div class="col-3">
    <div class="custom-card">
      <div class="custom-card-header">
        <h4>Orders</h4>
        <h4>
          <?php
          $orders = $conn -> query("SELECT * FROM orders ") -> num_rows;
          echo format_num($orders);
          ?>
        </h4>
      </div>
      <div class="custom-card-body">
        <a href="?page=sales" class="w-100 btn btn-primary">Manage Orders</a>
      </div>
    </div>
  </div>
  <div class="col-3">
    <div class="custom-card">
      <div class="custom-card-header">
        <h4>Total Sales</h4>
        <h4>
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
        </h4>
      </div>
      <div class="custom-card-body">
        <a href="?page=sales" class="w-100 btn btn-primary">Manage Sales</a>
      </div>
    </div>
  </div>
</div>