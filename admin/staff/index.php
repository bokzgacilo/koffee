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
        <form>
          <div class="form-group">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" required />
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button id="completeorderbutton" type="button" class="btn btn-primary" aria-label="Complete">Add Staff</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
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
              return `
                <button class='btn btn-sm btn-danger'>Deactivate</button>
              `
            }
        }
      ]
    });
  })
</script>
