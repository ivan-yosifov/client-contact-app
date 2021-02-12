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
					<a href="#" class="btn btn-success btn-sm">View</a>
					<a href="#" class="btn btn-primary btn-sm">Update</a>
					<a href="#" class="btn btn-danger btn-sm">Delete</a>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>



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