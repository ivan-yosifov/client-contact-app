<?php
include './db.php';
require_once 'vendor/autoload.php';

if(isset($_POST['generate'])){
	$faker = Faker\Factory::create();

	$sql = "INSERT INTO clients (name, email, phone, address, description, date_created) VALUES (:name, :email, :phone, :address, :description, :date_created)";
	$stmt = $pdo->prepare($sql);

	for($i = 0; $i < 100; $i++){
		$stmt->execute([
			':name' => $faker->name,
			':email' => $faker->email,
			':phone' => $faker->phoneNumber,
			':address' => $faker->address,
			':description' => $faker->paragraph,
			':date_created' => date('Y-m-d')
		]);
	}
}


?>

<form action="faker.php" method="post">
	<button type="submit" name="generate">Generate Fake data</button>
</form>