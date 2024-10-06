<style>
  .container-fluid {
    background-color: #fff;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  #detail {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
  }

  #detail > div {
    display: flex;
    flex-direction: row;
  }

  #detail > div > p {
    margin: 0;
  }

  #detail > .receipt {
    display: flex;
    flex-direction: column;
  }

  .receipt > img {
    width: 120px;
    height: auto;
    object-fit: cover;
  }

  #detail > div > p:first-of-type {
    font-weight: 500;
  }
</style>

<div class="container-fluid">
  <h1>List of Orders</h1>
  <div class="d-flex flex-row">
    <div class="col-7">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Client ID</th>
          <th>Order Date</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
          include("../api/connection.php");

          $result = $conn -> query("SELECT * FROM orders");

          if($result -> num_rows > 0){
            while($row = $result -> fetch_assoc()){
              echo "
                <tr>
                  <td>".$row['id']."</td>
                  <td>".$row['client_id']."</td>
                  <td>".$row['order_date']."</td>
                  <td>".$row['status']."</td>
                  <td>
                    <button onclick='viewOrder(".$row['id'].")' class='btn btn-sm btn-secondary'>View Order</button>
                    <button onclick='completeOrder(".$row['id'].")' class='btn btn-sm btn-primary'>Complete Order</button>
                  </td>
                </tr>
              ";
            }
          }
        ?>
      </tbody>
    </table>
    </div>
    <div class="col-5" id="detail">

    </div>
  </div>
  
</div>

<script>
  function completeOrder(id){
    Swal.fire({
      title: "Do you want complete this order?",
      showCancelButton: true,
      confirmButtonText: "Complete",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'post',
          url: "../api/complete_order.php",
          data : {
            id: id
          },
          success : response => {
            Swal.fire("Saved!", response, "info");
          }
        })
      }
    });
  }
 

  function viewOrder(id){
    $.ajax({
      type: 'get',
      url: '../api/get_order_details.php',
      data: {
        id:id
      },
      success: response => {
        $("#detail").html(response)
      }
    })
  }

	$(document).ready(function(){
		
	})
</script>