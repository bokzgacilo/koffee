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
  <h2 class="fw-bold mb-4">REFUNDS</h2>
  <div class="table-responsive">
    <table id="ordersTable" class="table">
      <thead>
        <th>Id</th>
        <th>Client</th>
        <th>Amount</th>
        <th>Gcash Reference</th>
        <th>Status</th>
        <th>Date</th>
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
      ajax: 'refund/get_all_refund.php',
      columns: [
        { data: 'id', title: 'Order Id' },
        { data: 'client_name', title: 'Client' },
        { data: 'amount', title: 'Amount' },
        { data: 'gcash_reference', title: 'Gcash Ref #' },
        { data: 'status', title: 'Status' },
        { data: 'date_created', title: 'Date' },
        { 
          data: 'id',
          title: 'Action',
          render: function(data, type, row) {
            if(row.status === "Pending"){
              return ` <button onclick='refund(${row.order_id})' class='btn btn-sm btn-primary'>Refund</button> `;

            }else {
              return ` <button class='btn btn-sm btn-success' disabled>Refunded</button> `;
            }
          }
        }
      ]
    });
  })
</script>

<script type="module">
  import {updateDocument} from "./firebase.js"

  window.refund = function(id){
    Swal.fire({
      title: "Do you want refund this order?",
      icon: "info",
      showCancelButton: true,
      confirmButtonText: "Refund",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'post',
          url: "refund/refund_order.php",
          data : {
            orderid: id
          },
          success : response => {
            if(response === "ok"){
              alert("Order refunded");

              location.reload();
            }
          }
        })
      }
    });
  }
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