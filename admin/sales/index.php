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
  <h2 class="fw-bold mb-4">ORDERS</h2>
  <div class="table-responsive">
    <table id="ordersTable" class="table">
      <thead>
        <th>Id</th>
        <th>Client</th>
        <th>Assigned Staff</th>
        <th>Date</th>
        <th>Status</th>
        <th>Action</th>
      </thead>
    </table>
  </div>
</div>

<!-- Order Detail Modal -->
<div class="modal fade" id="completeOrderModal" tabindex="-1" aria-labelledby="completeOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="completeOrderModalLabel">Proof Of Delivery Completion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="completeorderform" class="d-flex flex-column">
          <input type="hidden" name="orderidc" value="" />
          <input type="file" accept="image/*" class="form-control" name="proof_of_order" required/>
        </form>
      </div>
      <div class="modal-footer">
        <button id="completeorderbutton" type="button" class="btn btn-primary" aria-label="Complete">Complete</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="orderDetailModalLabel">Order Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="detail">
        
        <!-- Order details will be loaded here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="selectstaffModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="orderDetailModalLabel">Select Staff</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="selectstaffform">
          <input type="hidden" name="orderid" value="" />
          <select name="selectstaff" class='form-control'>
            <?php
              $staff = $conn -> query("SELECT * FROM staff");
              while($row = $staff -> fetch_assoc()){
                echo "
                  <option value='".$row['name']."'>".$row['name']."</option>
                ";
              }

            ?>
          </select>
        </form>
        <!-- Order details will be loaded here -->
      </div>
      <div class="modal-footer">
        <button id="selectStaffButton" type="button" class="btn btn-primary" aria-label="Complete">Select Staff</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
    $('#ordersTable').DataTable({
      ajax: 'sales/get_all_orders.php',
      columns: [
        { data: 'id', title: 'Order Id' },
        { data: 'client_name', title: 'Client' },
        { data: 'prepared_by', title: 'Assigned Staff' },
        { data: 'order_date', title: 'Date' },
        { data: 'status', title: 'Status' },
        { 
            data: 'id',
            title: 'Action',
            render: function(data, type, row) {
              let view_btn = `<button class="btn btn-sm btn-secondary view-order-btn" onclick='viewOrder(${data})'">View</button>`;
              if(row.status === "Completed"){
                return `
                  ${view_btn}
                  <button disabled class='btn btn-sm btn-success'>Completed</button>
                  <a class='btn btn-link btn-sm' href='../${row.proof_of_order}'>View Proof</a>
                `;
              }

              if(row.status === "Cancelled"){
                return `
                  ${view_btn}
                  <button disabled class='btn btn-sm btn-danger'>Cancelled</button>
                `;
              }

              if(row.status === "In-Delivery"){
                return `
                  ${view_btn}
                  <button class='btn btn-sm btn-success' onclick='completeOrder(${data})'>Complete Order</button>
                `;
              }

              if(row.status === "Pending"){
                return `
                  ${view_btn}
                  <button class='btn btn-sm btn-primary' onclick='prepareOrder(${data})'>Prepare Order</button>
                  <button class='btn btn-sm btn-danger' onclick='cancelOrder(${data})' >Cancel</button>
                `;
              }

              if(row.status === "Preparing"){
                return `
                  ${view_btn}
                  <button class='btn btn-sm btn-primary' onclick='deliverOrder(${data})'>Deliver Order</button>
                  <button class='btn btn-sm btn-danger' onclick='cancelOrder(${data})' >Cancel</button>
                `;
              }
            }
        }
      ]
    });
  })

  
</script>

<script type="module">
  import {updateDocument} from "./firebase.js"

  $("#completeorderbutton").click(function(){
    $("#completeorderform").submit()
  })

  $("#selectStaffButton").click(function(){
    $("#selectstaffform").submit()
  })

  $("#selectstaffform").submit(function(e){
    e.preventDefault();

    var formdata = new FormData(this)

    Swal.fire({
      title: "Do you want this staff prepare this order?",
      icon: "info",
      showCancelButton: true,
      confirmButtonText: "Yes, select staff.",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          contentType: false,
          processData: false, 
          type: 'post',
          data: formdata,
          url: "../api/prepare_order.php",
          success : response => {
            updateDocument($("input[name='orderid']").val(), `Your order was being prepared by ${$("select[name='selectstaff']").val()}.`)
            alert("Order Updated")
            location.reload();
          }
        })
      }
    });
  })

  $("#completeorderform").submit(function(e){
    e.preventDefault();

    var formdata = new FormData(this)

    Swal.fire({
      title: "Do you want complete this order?",
      icon: "info",
      showCancelButton: true,
      confirmButtonText: "Complete",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          contentType: false,
          processData: false, 
          type: 'post',
          data: formdata,
          url: "../api/complete_order.php",
          success : response => {
            updateDocument($("input[name='orderidc']").val(), "Order completed!")
            alert("Order Updated")
            location.reload();
          }
        })
      }
    });
  })
</script>

<script type="module">
  import {updateDocument} from "./firebase.js"

  window.cancelOrder = function(id){
    Swal.fire({
      title: "Do you want cancel this order?",
      icon: "info",
      showCancelButton: true,
      confirmButtonText: "Cancel",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'post',
          url: "../api/cancel_order.php",
          data : {
            id: id
          },
          success : response => {
            console.log(id)
            updateDocument(id, "Your order was cancelled by the Admin.")

            setTimeout(() => {
              alert('Order Updated');

              location.reload();
            }, 3000)
          }
        })
      }
    });
  }

  window.prepareOrder = function(id){
    $("#selectstaffModal").modal('toggle')
    $("input[name='orderid']").val(id)
  }

  window.deliverOrder = function(id){
    Swal.fire({
      title: "Do you want deliver this order?",
      icon: "info",
      showCancelButton: true,
      confirmButtonText: "Deliver",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'post',
          url: "../api/deliver_order.php",
          data : {
            id: id
          },
          success : response => {
            console.log(id)
            updateDocument(id, "Order is on the way to you!")
            setTimeout(() => {
              alert('Order Updated');

              location.reload();
            }, 3000)
          }
        })
      }
    });
  }

  window.completeOrder = function(id){
    $("#completeOrderModal").modal("toggle")
    $("input[name='orderidc']").val(id)
  }

  window.viewOrder = function(id){
    $.ajax({
      type: 'get',
      url: '../api/get_order_details.php',
      data: {
        id:id
      },
      success: response => {
        $("#orderDetailModal").modal("toggle")
        $("#detail").html(response)
      }
    })
  }
  
	$(document).ready(function(){
		
	})
</script>

<script>

  let scale = 1;
  const scaleStep = 0.5;
  let xOffset = 0;
  let yOffset = 0;
  const panStep = 50; // Pixels to pan on each button click

  function updateTransform() {
    $('#image').css('transform', `translate(${xOffset}px, ${yOffset}px) scale(${scale})`);
  }

  $(document).on("click", "#zoomIn", function(){
    $('#zoomIn').click(function () {
        scale += scaleStep;
        updateTransform();
    });
  })

  $(document).on("click", "#zoomOut", function(){
    $('#zoomOut').click(function () {
        if (scale > scaleStep) {
            scale -= scaleStep;
            updateTransform();
        }
    });
  })

  $(document).on("click", "#panUp", function(){
    $('#panUp').click(function () {
        yOffset += panStep;
        updateTransform();
    });
  })

  $(document).on("click", "#panDown", function(){
    $('#panDown').click(function () {
      yOffset -= panStep;
      updateTransform();
    });
  })

  $(document).on("click", "#panLeft", function(){
    $('#panLeft').click(function () {
      xOffset += panStep;
      updateTransform();
    });
  })

  $(document).on("click", "#panRight", function(){
    $('#panRight').click(function () {
        xOffset -= panStep;
        updateTransform();
    });
  })

</script>