<?php

if($_SERVER['REQUEST_METHOD'] != 'POST'){
	header('Location: index.php');
	exit();
}

if(!isset($_POST['generate'])) {
	header('Location: index.php');
	exit();
}

session_start();
include './db.php';
require_once 'vendor/autoload.php';

if(isset($_POST['generate'])){
	$faker = Faker\Factory::create();

	$sql = "INSERT INTO clients (name, email, phone, address, description, date_created) VALUES (:name, :email, :phone, :address, :description, :date_created)";
	$stmt = $pdo->prepare($sql);

	for($i = 0; $i < 20; $i++){
		$stmt->execute([
			':name' => $faker->name,
			':email' => $faker->email,
			':phone' => $faker->phoneNumber,
			':address' => $faker->address,
			':description' => $faker->paragraph,
			':date_created' => date('Y-m-d')
		]);
	}
	$_SESSION['flash'] = array();
		array_push($_SESSION['flash'], [
		'class' => 'success',
		'msg' => 'Successfully added 20 fake clients'
	]);

	header('Location: index.php');
	exit();
}


?>

