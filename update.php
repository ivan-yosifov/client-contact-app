<?php

if($_SERVER['REQUEST_METHOD'] != 'POST'){
	header('Location: index.php');
	exit();
}

if(!isset($_POST['update'])){
	header('Location: index.php');
	exit();
}

session_start();
include './db.php';

$id = trim($_POST['id']);
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
		'id' => $id,
		'name' => $name,
		'email' => $email,
		'phone' => $phone,
		'address' => $address,
		'description' => $description
	);

	header('Location: index.php');
	exit();
}


$sql = "UPDATE clients SET name = :name, email = :email, phone = :phone, address = :address, description = :description, date_created = :date_created WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([
	':id' => $id,
	':name' => $name,
	':email' => $email,
	':phone' => $phone,
	':address' => $address,
	':description' => $description,
	':date_created' => $date_created
]);


// update successfull - redirect to home page
array_push($_SESSION['flash'], [
	'class' => 'success',
	'msg' => 'Contact has been successfully updated'
]);
header('Location: index.php');
exit();
