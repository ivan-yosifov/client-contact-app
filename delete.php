<?php

if($_SERVER['REQUEST_METHOD'] != 'POST'){
	header('Location: index.php');
	exit();
}

if(!isset($_POST['delete']) || !isset($_POST['delete_id'])){
	header('Location: index.php');
	exit();
}

session_start();
include './db.php';

$id = trim($_POST['delete_id']);

$sql = "DELETE FROM clients WHERE id = :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);


// update successfull - redirect to home page
array_push($_SESSION['flash'], [
	'class' => 'success',
	'msg' => 'Contact has been successfully deleted'
]);
header('Location: index.php');
exit();
