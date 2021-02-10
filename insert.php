<?php
session_start();
include './db.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
	header('Location: index.php');
	exit();
}

if(!isset($_POST['add'])){
	header('Location: index.php');
	exit();
}

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$address = trim($_POST['address']);
$description = trim($_POST['description']);
$date_created = date('Y-m-d');

$_SESSION['flash'] = array();

// validation
if(strlen($name) < 3){
	array_push($_SESSION['flash'], [
		'class' => 'danger',
		'msg' => 'Name must be at least 3 characters'
	]);
}
if(strlen($email) < 4){
	array_push($_SESSION['flash'], [
		'class' => 'danger',
		'msg' => 'Email must be at least 4 characters'
	]);
}
if(strlen($address) < 5){
	array_push($_SESSION['flash'], [
		'class' => 'danger',
		'msg' => 'Address must be at least 5 characters'
	]);
}

// There are errors so redirect back to add client form
if(!empty($_SESSION['flash'])){
	$_SESSION['info'] = array(
		'name' => $name,
		'email' => $email,
		'phone' => $phone,
		'address' => $address,
		'description' => $description
	);

	header('Location: index.php');
	exit();
}


$sql = "INSERT INTO clients (name, email, phone, address, description, date_created) VALUES (:name, :email, :phone, :address, :description, :date_created)";
$stmt = $pdo->prepare($sql);
$stmt->execute([
	':name' => $name,
	':email' => $email,
	':phone' => $phone,
	':address' => $address,
	':description' => $description,
	':date_created' => $date_created
]);

// insert successfull - redirect to home page
if($stmt->rowCount() != 0){
	array_push($_SESSION['flash'], [
		'class' => 'success',
		'msg' => 'Contact has been successfully added'
	]);
	header('Location: index.php');
	exit();
}