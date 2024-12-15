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
  <h2 class="fw-bold mb-4">STAFF</h2>
  <div>
  <button type="button" class="btn btn-primary" id="add-staff-button">Add Staff</button>
  </div>
  <div class="table-responsive">
    <table id="ordersTable" class="table">
      <thead>
        <th>Id</th>
        <th>Name</th>
        <th>Date Added</th>
        <th>Action</th>
      </thead>
    </table>
  </div>
</div>

<script>
  $("#add-staff-button").on("click", function(){
    $("#exampleModal").modal("toggle")
  })
</script>

<!-- Order Detail Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModal">Add Staff</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="add-staff-form">
          <div class="form-group">
            <label class="form-label">Name</label>
            <input type="text" class="form-control"  name="staffname" required/>
          </div>
          <button type="submit" class="btn btn-primary btn-sm">Add Staff</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
    $('#ordersTable').DataTable({
      ajax: 'staff/get_all_staffs.php',
      columns: [
        { data: 'id', title: 'Id' },
        { data: 'name', title: 'Name' },
        { data: 'date_added', title: 'Date' },
        { 
            data: 'id',
            title: 'Action',
            render: function(data, type, row) {
              console.log(row)
              if(row.is_active == true){
                return `
                  <button data-target='${row.id}' id='deactivate-button' class='btn btn-sm btn-danger'>Deactivate</button>
                `
              }
              
              if(row.is_active == false){ 
                return `
                  <button data-target='${row.id}' id='activate-button' class='btn btn-sm btn-success'>Activate</button>
                `
              }
            }
        }
      ]
    });
  })

  $(document).on("submit", "#add-staff-form", function(e){
    e.preventDefault();

    let formdata = new FormData(this)

    $.ajax({
      type: 'post',
      url: '../api/post_staff_add.php',
      contentType: false,
      processData: false, 
      data: formdata,
      success: response => {
        if(response === "ok"){
          alert("Staff Added!");
          location.reload();
        }
      }
    })
  })

  $(document).on("click", "#deactivate-button", function(e){
    let target = $(this).attr('data-target');

    $.ajax({
      type: 'post',
      url: '../api/post_staff_deactivate.php',
      data: {
        staffid : target
      },
      success: response => {
        if(response === "ok"){
          alert("Staff Deactivated!");
          location.reload();
        }
      }
    })
  })

  $(document).on("click", "#activate-button", function(e){
    let target = $(this).attr('data-target');

    $.ajax({
      type: 'post',
      url: '../api/post_staff_activate.php',
      data: {
        staffid : target
      },
      success: response => {
        if(response === "ok"){
          alert("Staff Activated");
          location.reload();
        }
      }
    })
  })
</script>

