<?php
session_start();
include './db.php';
include './header.php';

$sql = "SELECT * FROM clients";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$clients = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
<div class="container">
	<h1 class="mb-4">Your client information <small class="float-end fs-4">Total: <?php echo $stmt->rowCount(); ?></small></h1>

	<div class="d-flex">
		<p class="lead me-3">Generate clients - </p>
		<form action="<?php echo htmlspecialchars('./faker.php'); ?>" class="d-inline" method="post">
			<button type="submit" class="btn btn-warning btn-sm" name="generate">Add 20 clients</button>
		</form>
	</div>

	<?php if(isset($_SESSION['flash'])): ?>
		<?php foreach($_SESSION['flash'] as $flash): ?>
		<?php if($flash['class'] != 'danger'): ?>
		<p class="alert alert-<?php echo $flash['class']; ?> py-2"><?php echo $flash['msg']; ?></p>
		<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<table id="clients" class="table">
		<thead>
			<tr>
	      <th scope="col">Name</th>
	      <th scope="col">Email</th>
	      <th scope="col">Phone</th>
	      <th scope="col">Address</th>
	      <th scope="col">Description</th>
	      <th scope="col">Date</th>
	      <th scope="col">Actions</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($clients as $client): ?>
			<tr>
				<td><?php echo $client->name; ?></td>
				<td><?php echo $client->email; ?></td>
				<td><?php echo $client->phone; ?></td>
				<td><?php echo $client->address; ?></td>
				<td><?php echo $client->description; ?></td>
				<td><?php echo $client->date_created; ?></td>
				<td>
					<form action="<?php echo htmlspecialchars('./view.php'); ?>" method="post" class="d-inline">
						<input type="hidden" name="id" value="<?php echo $client->id; ?>">
						<button type="submit" class="btn btn-success btn-sm" name="view">View</button>
					</form>
					<button type="button" class="btn btn-primary btn-sm btn-update-modal" data-bs-toggle="modal" data-bs-target="#updateModal" data-id="<?php echo $client->id; ?>" data-name="<?php echo $client->name; ?>"  data-email="<?php echo $client->email; ?>" data-phone="<?php echo $client->phone; ?>" data-address="<?php echo $client->address; ?>" data-description="<?php echo $client->description; ?>">Update</button>
					<button type="button" class="btn btn-danger btn-sm btn-delete-modal" data-bs-toggle="modal" data-bs-target="#deleteModal" data-delete-id="<?php echo $client->id; ?>">Delete</button>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>


<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Client</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	<?php if(isset($_SESSION['flash'])): ?>
      	
		  		<?php foreach($_SESSION['flash'] as $flash): ?>
		  		<?php if($flash['class'] != 'success'): ?>
		  		<p class="alert alert-<?php echo $flash['class']; ?> py-2"><?php echo $flash['msg']; ?></p>
		  		<?php endif; ?>
		  		<?php endforeach; ?>
		  	<?php endif; ?>
        <form action="<?php echo htmlspecialchars('./update.php'); ?>" method="post" id="updateForm">
        	<input type="hidden" name="id" id="id" value="">
				  <div class="mb-3">
				    <label for="name" class="form-label">Name</label>
				    <input type="text" name="name" class="form-control" id="name" aria-describedby="name" value="">
				  </div>
				  <div class="mb-3">
				    <label for="email" class="form-label">Email</label>
				    <input type="text" name="email" class="form-control" id="email" aria-describedby="email" value="">
				  </div>
				  <div class="mb-3">
				    <label for="phone" class="form-label">Phone</label>
				    <input type="text" name="phone" class="form-control" id="phone" aria-describedby="phone" value="">
				  </div>
				  <div class="mb-3">
				    <label for="address" class="form-label">Address</label>
				    <input type="text" name="address" class="form-control" id="address" aria-describedby="address" value="">
				  </div>
				  <div class="mb-3">
				    <label for="description" class="form-label">Description</label>
				    <textarea name="description" class="form-control" id="description" aria-describedby="description"></textarea>
				  </div>
				  <div class="d-flex justify-content-end">
					  <button type="submit" class="btn btn-primary me-2" name="update">Update Client</button>
					  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					</div>
				</form>
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header  text-white bg-danger">
        <h5 class="modal-title" id="exampleModalLabel">Delete Client</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      	<h4>Are you sure you want to delete this contact?</h4>
        <form action="<?php echo htmlspecialchars('./delete.php'); ?>" method="post" id="deleteForm">
        	<input type="hidden" name="delete_id" id="delete_id" value="">				  
				  <div class="d-flex justify-content-end">
					  <button type="submit" class="btn btn-danger me-2" name="delete">Delete Client</button>
					  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					</div>
				</form>
      </div>
    </div>
  </div>
</div>

<script>
	var updateForm = document.getElementById('updateForm');
	var deleteForm = document.getElementById('deleteForm');
	var tableClients = document.getElementById('clients');

	tableClients.addEventListener('click', function(e){
		if(e.target.classList.contains('btn-update-modal')){
			var id = e.target.dataset.id;
			var name = e.target.dataset.name;
			var email = e.target.dataset.email;
			var phone = e.target.dataset.phone;
			var address = e.target.dataset.address;
			var description = e.target.dataset.description;
			
			updateForm.querySelector('#id').value = id;
			updateForm.querySelector('#name').value = name;
			updateForm.querySelector('#email').value = email;
			updateForm.querySelector('#phone').value = phone;
			updateForm.querySelector('#address').value = address;
			updateForm.querySelector('#description').value = description;
		}

		if(e.target.classList.contains('btn-delete-modal')){
			console.log(e.target);
			deleteForm.querySelector('#delete_id').value = e.target.dataset.deleteId;
		}
	});

</script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>

<script>
	$(document).ready( function () {
    // $('#clients').DataTable();

    $('#clients').dataTable( {
		  "columns": [
		    null,
		    null,
		    null,
		    null,
		    null,
		    null,
		    { "width": "18%" }
		  ]
		} );
	});
</script>



<?php include './footer.php'; ?>