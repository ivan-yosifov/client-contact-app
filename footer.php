    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <?php if(isset($_SESSION['info'])): ?>

		<script>
			var updateForm = document.getElementById('updateForm');
			var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
			updateModal.show();

			updateForm.querySelector('#id').value = "<?php echo $_SESSION['info']['id']; ?>";
			updateForm.querySelector('#name').value = "<?php echo $_SESSION['info']['name']; ?>";
			updateForm.querySelector('#email').value = "<?php echo $_SESSION['info']['email']; ?>";
			updateForm.querySelector('#phone').value = "<?php echo $_SESSION['info']['phone']; ?>";
			updateForm.querySelector('#address').value = "<?php echo $_SESSION['info']['address']; ?>";
			updateForm.querySelector('#description').value = "<?php echo $_SESSION['info']['description']; ?>";	
		</script>
		<?php endif; ?>
  </body>
</html>
<?php
// remove flash data
if(isset($_SESSION['flash'])){
	unset($_SESSION['flash']);
}

if(isset($_SESSION['info'])){
	unset($_SESSION['info']);
}
?>