<?php

session_start();
include './db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/phpmailer/phpmailer/src/Exception.php';
require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
require './vendor/phpmailer/phpmailer/src/SMTP.php';


$id = $_GET['id'];
$sql = "SELECT * FROM clients WHERE id = :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);

// if($stmt->rowCount() == 0){
// 	header('Location: index.php');
// 	exit();	
// }

$client = $stmt->fetch(PDO::FETCH_OBJ);


?>

<?php

	if(isset($_POST['sendEmail'])){



		$path = './uploads/'.$_FILES['image']['name'];
		move_uploaded_file($_FILES['image']['tmp_name'], $path);

		$mail = new PHPMailer(true);

		try {
	    //Server settings
	    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
	    $mail->isSMTP();                                            // Send using SMTP
	    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
	    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	    $mail->Username   = '';                     // SMTP username
	    $mail->Password   = '';                               // SMTP password
	    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
	    $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

	    //Recipients
	    $mail->setFrom($client->email, 'Mailer');
	    $mail->addAddress($client->email);

	    // Attachments
	    $mail->addAttachment($path);         // Add attachments
	    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

	    // Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = $_POST['subject'];
	    $mail->Body    = $_POST['message'];
	    $mail->AltBody = $_POST['message'];

	    $mail->send();
	    echo 'Message has been sent';

	    $client_id = $_GET['id'];
	    $subject = $_POST['subject'];
	    $message = $_POST['message'];
	    $sql = "INSERT INTO messages (client_id, subject, message, file, date_created) VALUES (:client_id, :subject, :message, :file, :date_created)";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute([
	    	':client_id' => $client_id,
	    	':subject' => $subject,
	    	':message' => $message,
	    	':file' => $path,
	    	':date_created' => date('Y-m-d')
	    ]);
		} catch (Exception $e) {
		    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}

	// get messages if any
	$sql = "SELECT * FROM messages WHERE client_id = :id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([':client_id' => $_GET['id']]);

	$messages = $stmt->fetchAll(PDO::FETCH_OBJ);

?>

<?php include './header.php'; ?>

<div class="container">
	<div class="row">
		<div class="col-md-6">
			<h2>Send Email</h2>
			<hr>
			<form action="<?php echo htmlspecialchars('./view.php'); ?>?id=<?php echo $client->id; ?>" method="post" enctype="multipart/form-data">
			  <div class="mb-3">
			    <label for="subject" class="form-label">Subject</label>
			    <input type="text" class="form-control" id="subject" name="subject" aria-describedby="subjectHelp">
			  </div>
			  <div class="mb-3">
			    <label for="message" class="form-label">Message</label>
			    <textarea class="form-control" id="message" name="message" aria-describedby="messageHelp"></textarea>
			  </div>
			  <div class="mb-3">
				  <label for="image" class="form-label">Image</label>
				  <input class="form-control" type="file" id="image" name="image">
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

		<div class="col-md-12">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Subject</th>
						<th>Message</th>
						<th>Date</th>
						<th>File</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($messages as $message): ?>
					<tr>
						<td><?php echo $message->subject; ?></td>
						<td><?php echo $message->message; ?></td>
						<td><?php echo $message->date; ?></td>
						<td><img src="<?php echo $message->file; ?>" alt=""></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>

