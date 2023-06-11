<!DOCTYPE html>
<html>
<?php
	require_once("components/config.php");

	$query= "SELECT * FROM users WHERE id=".$_SESSION['user']['id'];
	$predata = $db->prepare($query);
	$predata->execute();
	$user = $predata->fetch(PDO::FETCH_ASSOC);

	$query= "SELECT name, path FROM nfts JOIN users ON nfts.user_id = users.id WHERE users.id=".$_SESSION['user']['id'];
	$predata = $db->prepare($query);
	$predata->execute();
	$nfts = $predata->fetch(PDO::FETCH_ASSOC);

	$query= "SELECT * FROM newsletter WHERE user_id=".$_SESSION['user']['id'];
	$predata = $db->prepare($query);
	$predata->execute();
	$news = $predata->fetch(PDO::FETCH_ASSOC);

	if ($user["admin"]) {
		date_default_timezone_set("Europe/Paris");

		$query= "SELECT * FROM users";
		$predata = $db->prepare($query);
		$predata->execute();
		$usersData = $predata->fetchAll(PDO::FETCH_ASSOC);

		$query= "SELECT * FROM nfts";
		$predata = $db->prepare($query);
		$predata->execute();
		$nftsData = $predata->fetchAll(PDO::FETCH_ASSOC);

		$query= "SELECT * FROM auctions";
		$predata = $db->prepare($query);
		$predata->execute();
		$auctionsData = $predata->fetchAll(PDO::FETCH_ASSOC);

		echo var_dump($usersData);
		echo var_dump($nftsData);
		echo var_dump($auctionsData);
	}

	echo var_dump($user);
	echo var_dump($nfts);

?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="script.js"></script>
	<link href="font/fontawesome/css/fontawesome.min.css" rel="stylesheet">
  	<link href="font/fontawesome/css/brands.min.css" rel="stylesheet">
  	<link href="font/fontawesome/css/solid.min.css" rel="stylesheet">
	<title>Userpage - NFT Marketplace</title>
</head>
<body>
	<div id="bg">
		<img src="img/BG.png"/>
	</div>
	<img src="img/authors/<?php echo $user["avatar"] ?>.png">
	<p><?php echo $user["firstname"]." ".$user["lastname"] ?></p>
	<?php if ($user["admin"]) {	?>
			<p>Administrator</p>
	<?php } else { ?>
			<p>NFT Trader</p>
	<?php } ?>

	<?php if ($user["admin"]) {	?>
		<button>Switch to Admin panel</button>
	<?php } ?>

	<div id="userpanel">
		<h2>User Panel</h2>

		<p>First Name: <?php echo $user["firstname"] ?></p>
		<p>Last Name: <?php echo $user["lastname"] ?></p>
		<p>Email: <?php echo $user["email"] ?></p>
		<p>Newsletter: <?php echo !empty($news)?"Subscribed!":"Not subscribed to (yet)" ?></p>
	</div>

	<div id="admin">
		<h2>Admin Panel</h2>

		<h3>Users</h3>
		<table>
			<tbody>
				<tr>
					<th></th>
					<th>First Name</th>
					<th>Last Name</th>
				</tr>

				<?php foreach ($usersData as $key => $value) { ?>
					<tr>
						<th><img src="img/authors/<?php echo $value["avatar"] ?>.png"></th>
						<th><?php echo $value["firstname"] ?></th>
						<th><?php echo $value["lastname"] ?></th>
					</tr>
				<?php } ?>
			</tbody>
		</table>

		<h3>NFTs</h3>
		<ul>
			<?php foreach ($nftsData as $key => $value) { ?>
				<li><?php echo $value["name"] ?></li>
			<?php } ?>
		</ul>

		<h3>Auctions</h3>
		<ul>
			<?php foreach ($auctionsData as $key => $value) { ?>
				<li><?php echo date("d F Y - H:i", strtotime($value["enddate"])) ?></li>
			<?php } ?>
		</ul>
	</div>
</body>
</html>