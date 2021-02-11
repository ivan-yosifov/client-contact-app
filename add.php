<?php
session_start();
include './db.php';
include './header.php';
?>

<div class="container">
	<div class="row">
		<div class="col-md-6 offset-md-3">
			<div class="card mt-5 text-dark bg-light">
			  <div class="card-header text-center fs-5">
			    Add New Client
			  </div>
			  <div class="card-body">
			  	<?php if(isset($_SESSION['flash'])): ?>
			  		<?php foreach($_SESSION['flash'] as $flash): ?>
			  		<p class="alert alert-<?php echo $flash['class']; ?> py-2"><?php echo $flash['msg']; ?></p>
			  		<?php endforeach; ?>
			  	<?php endif; ?>
			    <form action="<?php echo htmlspecialchars('./insert.php') ?>" method="post">
					  <div class="mb-3">
					    <label for="name" class="form-label">Name</label>
					    <input type="text" name="name" class="form-control" id="name" aria-describedby="name" value="<?php if(isset($_SESSION['info']['name'])) echo $_SESSION['info']['name']; ?>">
					  </div>
					  <div class="mb-3">
					    <label for="email" class="form-label">Email</label>
					    <input type="text" name="email" class="form-control" id="email" aria-describedby="email" value="<?php if(isset($_SESSION['info']['email'])) echo $_SESSION['info']['email']; ?>">
					  </div>
					  <div class="mb-3">
					    <label for="phone" class="form-label">Phone</label>
					    <input type="text" name="phone" class="form-control" id="phone" aria-describedby="phone" value="<?php if(isset($_SESSION['info']['phone'])) echo $_SESSION['info']['phone']; ?>">
					  </div>
					  <div class="mb-3">
					    <label for="address" class="form-label">Address</label>
					    <input type="text" name="address" class="form-control" id="address" aria-describedby="address" value="<?php if(isset($_SESSION['info']['address'])) echo $_SESSION['info']['address']; ?>">
					  </div>
					  <div class="mb-3">
					    <label for="description" class="form-label">Description</label>
					    <textarea name="description" class="form-control" id="description" aria-describedby="description"><?php if(isset($_SESSION['info']['description'])) echo $_SESSION['info']['description']; ?></textarea>
					  </div>
					  <button type="submit" class="btn btn-success" name="add">Add Client</button>
					</form>
			  </div>
			</div>
		</div>
	</div>
</div>	

<?php include './footer.php'; ?>