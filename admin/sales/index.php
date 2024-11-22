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
        <th>Date</th>
        <th>Status</th>
        <th>Action</th>
      </thead>
    </table>
  </div>
</div>

<!-- Order Detail Modal -->
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
<script>
  $(document).ready(function(){
    $('#ordersTable').DataTable({
      ajax: 'sales/get_all_orders.php',
      columns: [
        { data: 'id', title: 'Order Id' },
        { data: 'client_name', title: 'Client' },
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
                  <button class='btn btn-sm btn-danger' onclick='cancelOrder(${data})'>Cancel</button>
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
    Swal.fire({
      title: "Do you want prepare this order?",
      icon: "info",
      showCancelButton: true,
      confirmButtonText: "Prepare",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'post',
          url: "../api/prepare_order.php",
          data : {
            id: id
          },
          success : response => {
            console.log(id)
            updateDocument(id, "Your order was being prepared.")

            setTimeout(() => {
              alert('Order Updated');

              location.reload();
            }, 3000)
          }
        })
      }
    });
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
    Swal.fire({
      title: "Do you want complete this order?",
      icon: "info",
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
            console.log(id)
            updateDocument(id, "Order completed!")
            

            setTimeout(() => {
              alert('Order Updated');

              location.reload();
            }, 3000)
            
          }
        })
      }
    });
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