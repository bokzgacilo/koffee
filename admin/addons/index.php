<?php if ($_settings->chk_flashdata('success')): ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>
<div class="card card-outline rounded-0 card-navy">
	<div class="card-header">
		<h3 class="card-title">List of Addons</h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-primary"><span
					class="fas fa-plus"></span> Create New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table" id="list">
				<thead>
					<tr>
						<th>#</th>
						<th>Name</th>
						<th>Price</th>
						<th>Category</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT * FROM addons ");
					while ($row = $qry->fetch_assoc()):
						?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo $row['name'] ?></td>
							<td><?php echo $row['price'] ?></td>
							<td>
                <?php
                  $id = $row['category_id'];
                  $getCategoryName = $conn -> query("SELECT name FROM category_list WHERE id=$id");
                  while($cat = $getCategoryName -> fetch_assoc()){
                    echo $cat['name'];
                  }
                ?>
              </td>
							<td> <?php if ($row['status'] == 1): ?>
									<span class="badge badge-success px-3 rounded-pill">Active</span>
								<?php else: ?>
									<span class="badge badge-danger px-3 rounded-pill">Inactive</span>
								<?php endif; ?>
							</td>
							<td align="center">
								<button type="button"
									class="btn btn-flat p-1 btn-default btn-sm dropdown-toggle dropdown-icon"
									data-toggle="dropdown">
									Action
									<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item edit_data" href="javascript:void(0)"
										data-id="<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span>
										Edit</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item delete_data" href="javascript:void(0)"
										data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span>
										Delete</a>
								</div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		$('.delete_data').click(function () {
			_conf("Are you sure to delete this Addon permanently?", "delete_addon", [$(this).attr('data-id')])
		})
		$('#create_new').click(function () {
			uni_modal("<i class='fa fa-plus'></i> Add New Addon", "addons/manage_addons.php")
		})
		$('.edit_data').click(function () {
			uni_modal("<i class='fa fa-edit'></i> Update Addon Details", "addons/manage_addons.php?id=" + $(this).attr('data-id'))
		})
		$('.table').dataTable({
			order: [0, 'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	})
	function delete_addon($id) {
		start_loader();
		console.log($id);
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=delete_addon",
			method: "POST",
			data: { id: $id },
			dataType: "json",
			error: function (jqXHR, textStatus, errorThrown) {
				console.log("AJAX Error: ", textStatus, errorThrown);
				console.log("Response Text: ", jqXHR.responseText);
				alert_toast("An error occurred.", 'error');
				end_loader();
			},
			success: function (resp) {
				console.log("Response: ", resp);
				if (typeof resp == 'object' && resp.status == 'success') {
					location.reload();
				} else {
					alert_toast("An error occurred.", 'error');
					end_loader();
				}
			}
		});

	}
</script>