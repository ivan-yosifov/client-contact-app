<?php
if($_SERVER['REQUEST_METHOD'] != 'POST'){
	header('Location: index.php');
	exit();
}

if(!isset($_POST['view']) || !isset($_POST['id'])){
	header('Location: index.php');
	exit();
}

session_start();
include './db.php';

$id = $_POST['id'];
$sql = "SELECT * FROM clients WHERE id = :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);

if($stmt->rowCount() == 0){
	header('Location: index.php');
	exit();	
}

$client = $stmt->fetch(PDO::FETCH_OBJ);

?>

<?php include './header.php'; ?>

<div class="container">
	<div class="row">
		<div class="col-md-6">
			<h2>Send Email</h2>
			<hr>
			<form action="<?php echo htmlspecialchars('./email.php'); ?>" method="post" enctype="multipart/form-data">
			  <div class="mb-3">
			    <label for="subject" class="form-label">Subject</label>
			    <input type="text" class="form-control" id="subject" aria-describedby="subjectHelp">
			  </div>
			  <div class="mb-3">
			    <label for="message" class="form-label">Message</label>
			    <textarea class="form-control" id="message" aria-describedby="messageHelp"></textarea>
			  </div>
			  <div class="mb-3">
				  <label for="image" class="form-label">Image</label>
				  <input class="form-control" type="file" id="image">
				</div>
			  <button type="submit" class="btn btn-success" name="sendEmail">Send Email</button>
			</form>
		</div>
		<div class="col-md-6">
			<div class="card">
			  <h5 class="card-header">Client Info</h5>
			  <div class="card-body">
			    <p><strong>Name: </strong> <?php echo $client->name; ?></p>
			    <p><strong>Email: </strong><?php echo $client->email; ?></p>
			    <p><strong>Phone: </strong><?php echo $client->phone; ?></p>
			    <p><strong>Address: </strong><?php echo $client->address; ?></p>
			    <p><strong>Description: </strong><?php echo $client->description; ?></p>
			  </div>
			</div>
		</div>
	</div>
</div>