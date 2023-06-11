<?php
	require_once("components/config.php");

	$query= "SELECT * FROM website_blocks";
	$predata = $db->prepare($query);
	$predata->execute();
	$data = $predata->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Login - NFT Marketplace</title>
</head>
<body>
	<div id="bg">
		<img src="img/BG.png"/>
	</div>

	<h1>Se connecter/S'inscrire à <span>NFT Marketplace!</span></h1>

	<?php
		if (isset($_SESSION['error'])) {
	?>
			<div class="error">
				<p><?php echo $_SESSION['error'] ?></p>
			</div>
	<?php }
		unset($_SESSION['error'])
	?>

	<div>
		<div>
			<h2>Se connecter</h2>
			<form action="actions/login.php" method="post">
				<input type="email" name="email" placeholder="E-mail">
				<input type="password" name="password" placeholder="Password">
				<input type="submit" name="" value="Se connecter">
			</form>
		</div>
		<div>
			<h2>S'inscrire</h2>
			<form action="actions/sign_in.php" method="post">
				<input type="text" name="firstname" placeholder="First name">
				<input type="text" name="lastname" placeholder="Last name">
				<input type="email" name="email" placeholder="E-mail">
				<input type="password" name="password" placeholder="Password">
				<input type="submit" name="" value="S'inscrire">
			</form>
		</div>
	</div>

	<?php require_once("components/footer.php") ?>
</body>
</html>