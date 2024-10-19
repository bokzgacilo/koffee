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
  <h1>Feedbacks</h1>
  <div class="d-flex flex-row">
    <div class="col-12">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Id</th>
          <th>Customer Name</th>
          <th>Customer Email</th>
          <th>Feedback</th>
          <th>Rating</th>
          <th>Date Submitted</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
          include("../api/connection.php");

          $result = $conn -> query("SELECT * FROM customer_feedback");

          if($result -> num_rows > 0){
            while($row = $result -> fetch_assoc()){
              echo "
                <tr>
                  <td>".$row['id']."</td>
                  <td>".$row['customer_name']."</td>
                  <td>".$row['customer_email']."</td>
                  <td>".$row['feedback']."</td>
                  <td>".$row['rating'].".0</td>
                  <td>".$row['submitted_at'].".0</td>
                  <td>
                    <button class='btn btn-danger btn-sm' onclick='removeFeedback(".$row['id'].")'>Remove Feedback</button>
                  </td>
                </tr>
              ";
            }
          }else {
            echo "No feedbacks to show.";
          }
        ?>
      </tbody>
    </table>
    </div>
  </div>
</div>

<script>
  function removeFeedback(id){
    Swal.fire({
      title: "Do you want remove this feedback?",
      icon: "info",
      showCancelButton: true,
      confirmButtonText: "Remove",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: 'post',
          url: "../api/remove_feedback.php",
          data : {
            id: id
          },
          success : response => {
            alert('Feedback Removed!.');
            location.reload();
          }
        })
      }
    });
  }
</script>