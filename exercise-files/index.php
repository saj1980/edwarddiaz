<?php include('includes/header.php'); ?>

<?php include('includes/nav.php'); ?>
	
<div class="container">

	<div class="jumbotron">
		<h1 class="text-center"> Home Page</h1>
	</div>

<?php  

	$sql = "SELECT * FROM users";
	$result = query($sql);
	confirm($result);

	$row = mysqli_fetch_array($result);

	echo '<button type="button" class="btn btn-default">' . $row['first_name'] . " " . $row['last_name'] . '</button>';

?>

<?php include('includes/footer.php'); ?>
