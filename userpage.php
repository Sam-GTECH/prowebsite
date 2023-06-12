<!DOCTYPE html>
<html>
<?php
	require_once("components/config.php");

	if (!isset($_SESSION['user'])) {
		header("Location:./login.php");
		die();
	}

	$query= "SELECT * FROM users WHERE id=".$_SESSION['user']['id'];
	$predata = $db->prepare($query);
	$predata->execute();
	$user = $predata->fetch(PDO::FETCH_ASSOC);

	$query= "SELECT nfts.id AS token_id, name, path FROM nfts JOIN users ON nfts.user_id = users.id WHERE users.id=".$_SESSION['user']['id'];
	$predata = $db->prepare($query);
	$predata->execute();
	$nfts = $predata->fetchAll(PDO::FETCH_ASSOC);

	$query= "SELECT * FROM newsletter WHERE user_id=".$_SESSION['user']['id'];
	$predata = $db->prepare($query);
	$predata->execute();
	$news = $predata->fetch(PDO::FETCH_ASSOC);

	$query= "SELECT * FROM auctions JOIN nfts ON nfts.id = auctions.nft_id";
	$predata = $db->prepare($query);
	$predata->execute();
	$auctionsData = $predata->fetchAll(PDO::FETCH_ASSOC);

	if ($user["admin"]) {
		date_default_timezone_set("Europe/Paris");

		$query= "SELECT * FROM users";
		$predata = $db->prepare($query);
		$predata->execute();
		$usersData = $predata->fetchAll(PDO::FETCH_ASSOC);

		$query= "SELECT nfts.id AS token_id, user_id, name, path, firstname, lastname FROM nfts JOIN users ON nfts.user_id = users.id";
		$predata = $db->prepare($query);
		$predata->execute();
		$nftsData = $predata->fetchAll(PDO::FETCH_ASSOC);

		$query= "SELECT * FROM website_blocks";
		$predata = $db->prepare($query);
		$predata->execute();
		$siteTexts = $predata->fetch(PDO::FETCH_ASSOC);

		$query= "SELECT website_nfts.id AS site_id, nfts.id AS token_id, path FROM website_nfts JOIN nfts ON website_nfts.nft_id = nfts.id";
		$predata = $db->prepare($query);
		$predata->execute();
		$siteImgs = $predata->fetchAll(PDO::FETCH_ASSOC);
	}

?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="script.js"></script>
	<link href="font/fontawesome/css/fontawesome.min.css" rel="stylesheet">
  	<link href="font/fontawesome/css/brands.min.css" rel="stylesheet">
  	<link href="font/fontawesome/css/solid.min.css" rel="stylesheet">
	<title>Utilisateur - NFT Marketplace</title>
</head>
<body>
	<div id="bg">
		<img src="img/BG.webp"/>
	</div>
	<div class="user_main_infos">
		<img src="img/authors/<?php echo $user["avatar"] ?>.webp">
		<div class="user_text">
			<p class="user_name"><?php echo $user["firstname"]." ".$user["lastname"] ?></p>
			<?php if ($user["admin"]) {	?>
					<p class="use_rank">Administrateur</p>
			<?php } else { ?>
					<p class="use_rank">Echangeur NFT</p>
			<?php } ?>
		</div>
	</div>

	<?php if ($user["admin"]) {	?>
		<button class="admin_switch" onclick="inversePanel()">Passer au panel Admin</button>
	<?php } ?>

	<div id="userpanel">
		<h2>Panel Utilisateur</h2>

		<div class="container">
		<p>Prénom: <?php echo $user["firstname"] ?></p>
		<p>Nom: <?php echo $user["lastname"] ?></p>
		<p>Email: <?php echo $user["email"] ?></p>
		<p>Newsletter: <?php echo !empty($news)?"Abonné!":"Pas (encore) abonné" ?></p>

		<h3>NFTs</h3>
			<?php if (!empty($nfts)) { ?>
			<table class="limit-images">
				<tbody>
					<tr>
						<th></th>
						<th>Nom</th>
						<th>En enchère</th>
						<th>Prix</th>
						<th>Paramètres</th>
					</tr>
					<?php foreach ($nfts as $key => $value) { ?>
						<tr>
							<th><img src="img/NFTs/<?php echo $value["path"] ?>.webp"></th>
							<th><?php echo $value["name"] ?></th>
							<th><?php 
								$inAuction = 0;
								foreach ($auctionsData as $key2 => $value2) {
									if ($value["token_id"] == $value2["nft_id"]) {
										$inAuction = $value2["price"];
										break;
									}
								}
								echo $inAuction?"Oui":"Non";
							?></th>
							<th><?php echo $inAuction?$inAuction."ETH":"---" ?></th>
							<th>
								<form action="actions/remove_nft.php" method="post">
									<input type="hidden" name="id" value="<?php echo $value["token_id"] ?>">
									<input class="important" type="submit" value="Supprimer le NFT">
								</form>
							</th>
						</tr>
					<?php } ?>
				<?php } else { echo "Tu n'as pas encore ajouté de NFTs.<br>Et si tu commençais?"; } ?>
				</tbody>
			</table>

			<div>
				<form action="actions/add_nft.php" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php echo $user["id"] ?>">
					<label for="image">NFT</label>
					<input type="file" name="image" accept="image/png, image/jpeg">
					<label for="text">Nom</label>
					<input type="text" name="name">
					<label for="text">Description</label>
					<input type="text" name="description">
					<input type="submit" value="Ajouter NFT">
				</form>
			</div>
		</div>
	</div>

	<div id="adminpanel" class="hidden">
		<h2>Panel Admin</h2>

		<div class="container">
			<h3>Utilisateurs</h3>
			<table>
				<tbody>
					<tr>
						<th></th>
						<th>Prénom</th>
						<th>Nom</th>
						<th>Email</th>
					</tr>

					<?php foreach ($usersData as $key => $value) { ?>
						<tr>
							<th><img src="img/authors/<?php echo $value["avatar"] ?>.webp"></th>
							<th><?php echo $value["firstname"] ?></th>
							<th><?php echo $value["lastname"] ?></th>
							<th><?php echo $value["email"] ?></th>
							<th class="param-table">
								<form action="actions/admin/reset_avatar.php" method="post">
									<input type="hidden" name="id" value="<?php echo $value["id"] ?>">
									<input type="submit" value="Réinitialiser l'avatar">
								</form>
								<form action="actions/admin/remove_user.php" method="post">
									<input type="hidden" name="id" value="<?php echo $value["id"] ?>">
									<input class="important" type="submit" value="Supprimer l'utilisateur">
								</form>
							</th>
						</tr>
					<?php } ?>
				</tbody>
			</table>

			<h3>NFTs</h3>
			<table class="limit-images">
				<tbody>
					<tr>
						<th></th>
						<th>Nom</th>
						<th>Crée par</th>
						<th>En enchère</th>
						<th>Prix</th>
						<th>Paramètres</th>
					</tr>
					<?php foreach ($nftsData as $key => $value) { ?>
						<tr>
							<th><img src="img/NFTs/<?php echo $value["path"] ?>.webp"></th>
							<th><?php echo $value["name"] ?></th>
							<th><?php echo $value["firstname"]." ".$value["lastname"] ?></th>
							<th><?php 
								$inAuction = 0;
								foreach ($auctionsData as $key2 => $value2) {
									if ($value["token_id"] == $value2["nft_id"]) {
										$inAuction = $value2["price"];
										break;
									}
								}
								echo $inAuction?"Oui":"Non";
							?></th>
							<th><?php echo $inAuction?$inAuction."ETH":"---" ?></th>
							<th>
								<form action="actions/remove_nft.php" method="post">
									<input type="hidden" name="id" value="<?php echo $value["token_id"] ?>">
									<input class="important" type="submit" value="Supprimer le NFT">
								</form>
							</th>
						</tr>
					<?php } ?>
				</tbody>
			</table>

			<h3>Enchères</h3>
			<table>
				<tbody>
					<tr>
						<th>NFT</th>
						<th>Valeur Actuelle</th>
						<th>Terminé?</th>
						<th>Fin dee l'enchère</th>
						<th>Paramètres</th>
					</tr>
					<?php foreach ($auctionsData as $key => $value) { ?>
						<tr>
							<th><?php echo $value["name"] ?></th>
							<th><?php echo $value["price"] ?></th>
							<th><?php echo $value["ongoing"]?"Non":"Oui" ?></th>
							<th><?php
								setlocale(LC_TIME, substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5));

								echo strftime("%d %B %Y, %H:%M:%S", strtotime($value["enddate"]))
							?></th>
							<th class="param-table"><form action="actions/admin/close_auction">
									<input type="hidden" name="id" value="<?php echo $value["id"] ?>">
									<input type="submit" value="Fermer l'enchère">
								</form>
								<form action="actions/admin/remove_auction.php">
									<input type="hidden" name="id" value="<?php echo $value["id"] ?>">
									<input class="important" type="submit" value="Supprimer l'enchère">
								</form>
							</th>
						</tr>
					<?php } ?>
				</tbody>
			</table>

			<h3>Site</h3>
				<h4>Blocks</h4>
				<form action="actions/admin/change_blocks.php" method="post">
					<table>
						<tbody>
							<tr>
								<th>Field</th>
								<th>Value</th>
							</tr>
							<?php
								foreach ($siteTexts as $key => $value) {
									$color = [
									    '<span>' => '[color]',
									    '</span>' => '[/color]',
									    '<br>' => '[nextline]'
									];

									$value = str_replace(array_keys($color), array_values($color), $value);?>
									<tr>
										<th><?php echo $key ?></th>
										<th><textarea name="<?php echo $key ?>" rows="1" cols="50" oninput="adaptTextAreaSize(this)"><?php echo $value ?></textarea></th>
									</tr>
							<?php } ?>
							<input type="submit" value="Save changes">
						</tbody>
					</table>
				</form>

				<h4>Images</h4>
					<table class="limit-images">
						<tbody>
							<tr>
								<th>Field</th>
								<th>Image</th>
								<th></th>
							</tr>
							<form action="actions/change_shownNfts">
								<datalist id="nfts">
									<?php foreach ($nftsData as $key => $value) { ?>
								  		<option value="<?php echo $value["name"] ?>"></option>
								  	<?php } ?>
								</datalist>
							<?php
								foreach ($siteImgs as $key => $value) { ?>
									<tr>
										<th><?php echo $key ?></th>
										<th><img src="img/NFTs/<?php echo $value["path"] ?>.webp"></th>
										<th><input list="nfts"></th>
									</tr>
							<?php } ?>
							<input type="submit" value="Save changes">
							</form>
						</tbody>
					</table>
		</div>
	</div>
</body>
</html>