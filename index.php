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

	<table id="clients" class="table">
		<thead>
			<tr>
	      <th scope="col">Name</th>
	      <th scope="col">Email</th>
	      <th scope="col">Phone</th>
	      <th scope="col">Address</th>
	      <th scope="col">Description</th>
	      <th scope="col">Date</th>
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
    $('#clients').DataTable();
} );
</script>

<?php include './footer.php'; ?>