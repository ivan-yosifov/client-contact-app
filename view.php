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
		} catch (Exception $e) {
		    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}
	}
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
	</div>
</div>

