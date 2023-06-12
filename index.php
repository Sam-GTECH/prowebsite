<!DOCTYPE html>
<html lang="FR-fr">
<?php
	require_once("components/config.php");

	$query= "SELECT * FROM website_blocks";
	$predata = $db->prepare($query);
	$predata->execute();
	$data = $predata->fetch(PDO::FETCH_ASSOC);

	$query= "SELECT * FROM website_nfts";
	$predata = $db->prepare($query);
	$predata->execute();
	$dataNFTs = $predata->fetchAll(PDO::FETCH_ASSOC);

	$query= "SELECT auctions.id, nft_id, user_id, name, path, price, enddate, isMainShown, isWeeklyShown FROM auctions JOIN nfts ON auctions.nft_id = nfts.id";
	$predata = $db->prepare($query);
	$predata->execute();
	$dataAuctions = $predata->fetchAll(PDO::FETCH_ASSOC);

	$query= "SELECT nfts.id, name, path, description, firstname, lastname, avatar FROM nfts JOIN users ON nfts.user_id = users.id;";
	$prenft = $db->prepare($query);
	$prenft->execute();
	$NFTs = $prenft->fetchAll(PDO::FETCH_ASSOC);

	$showcasedAuction = NULL;
	$weeklyShownAuctions = array();

	foreach ($dataAuctions as $key => $value) {
		if ($value["isMainShown"] && is_null($showcasedAuction))
			$showcasedAuction = $value;
		if ($value["isWeeklyShown"] && count($weeklyShownAuctions)<3)
			array_push($weeklyShownAuctions, $value);
	}
?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script>
		const showcaseDate = "<?php echo $showcasedAuction["enddate"] ?>"
		const weeklyDates = [<?php echo '"'.$weeklyShownAuctions[0]["enddate"].'"'.",".'"'.$weeklyShownAuctions[1]["enddate"].'"'.",".'"'.$weeklyShownAuctions[2]["enddate"].'"' ?>]
	</script>
	<link href="font/fontawesome/css/fontawesome.min.css" rel="stylesheet">
  	<link href="font/fontawesome/css/brands.min.css" rel="stylesheet">
  	<link href="font/fontawesome/css/solid.min.css" rel="stylesheet">
	<title><?php echo $data['title_site'] ?></title>
	<meta name="description" content="<?php echo $data['description_site'] ?>">
</head>
<body>
	<div id="bg">
		<img src="img/BG.webp" alt="Fond de NFT Marketplace"/>
	</div>
	<nav>
		<div id ="navbar">
			<a id="focus" href="marketplace">Marketplace</a>
			<a href="artists">Artistes</a>
			<a href="community">Communauté</a>
			<a href="collections">Collections</a>
		</div>
		<div id="right_nav">
			<a id="contact-button" href="#contact">Contact</a>
			<?php if (isset($_SESSION['user'])) { ?>
				<a href="userpage.php"><img src="img/authors/<?php echo $_SESSION['user']["avatar"] ?>.webp" alt="Profile"></a>
			<?php } ?>
		</div>
	</nav>
	<?php
		if (isset($_SESSION['message'])) {
	?>
			<div class="message">
				<p><?php echo $_SESSION['message'] ?></p>
			</div>
	<?php }
		unset($_SESSION['message'])
	?>
	<div class="main">
		<div class="summary">
			<div class="left">
				<h1><?php echo $data['title_main'] ?></h1>
				<p><?php echo $data['text_main'] ?></p>
				<div class="buttons">
					<a class="button1"><?php echo $data['button_main'] ?></a>
					<a class="button2"><?php echo $data['text_second_button'] ?></a>
				</div>
				<div class="stats">
					<div>
						<p class="numbers"><span>8.9</span>K</p>
						<p>Travaux</p>
					</div>
					<div class="vertibar"></div>
					<div>
						<p class="numbers"><span>65</span>K</p>
						<p>Artistes</p>
					</div>
					<div class="vertibar"></div>
					<div>
						<p class="numbers"><span>87</span>K</p>
						<p>Collections</p>
					</div>
				</div>
			</div>
			<div class="right">
				<img src="img/NFTs/<?php echo $showcasedAuction["path"] ?>.webp" alt="NFT <?php echo $showcasedAuction["name"] ?>"/>
				<div class="glow"></div>
				<div class="container bid_square">
					<div class="bid">
						<div class="bid_part">
							<p class="colorPri">Fin dans</p><p id="timeleft_main" class="bold">00:00:00</p>
						</div>
						<div class="bid_part">
							<p class="colorPri">Enchère actuelle</p><p id="value" class="bold"><?php
								$sql = "SELECT `user_id`, `auction_id`, `value` FROM `users_bid` WHERE auction_id=".$showcasedAuction["id"]." ORDER BY value DESC LIMIT 1";
								$pre = $db->prepare($sql);
								$pre->execute();
								$showcaseData = $pre->fetch(PDO::FETCH_ASSOC);
								echo $showcaseData["value"] ?>
							ETH</p>
						</div>
					</div>
					<div id="main_bid_button" class="bid_button">
						<button onclick="showBidUI(<?php echo (isset($_SESSION['user'])) ?>, 'main')">Placer une enchère</button>
					</div>
					<div id="main_bid_info" class="bid_info">
						<p class="name"><?php echo $NFTs[$dataNFTs[0]["id"]-1]["name"] ?></p>
						<p class="description"><?php echo $NFTs[$dataNFTs[0]["id"]-1]["description"] ?></p>
						<p class="author"><span>Crée par:</span> <?php echo $NFTs[$dataNFTs[0]["id"]-1]["firstname"]." ".$NFTs[$dataNFTs[0]["id"]-1]["lastname"] ?></p>
						<form action="actions/bet.php" method="post">
							<label>Place your prize</label>
							<input type="hidden" name="auction_id" value="<?php echo $showcasedAuction["id"] ?>">
							<input type="hidden" name="user_id" value="<?php echo $_SESSION['user']['id'] ?>">
							<input type="number" step="0.01" name="price">
							<input type="submit" value="Poser l'enchère">
						</form>
					</div>
				</div>
			</div>
		</div>
		<div id="marketplace" class="coolart">
			<div class="title">
				<h2><?php echo $data['title_marketplace'] ?></h2>
				<a><?php echo $data['button_marketplace'] ?></a>
			</div>
			<div class="gallery">
				<div class="container">
					<img src="img/NFTs/<?php echo $weeklyShownAuctions[0]["path"] ?>.webp" alt="NFT <?php echo $NFTs[$weeklyShownAuctions[0]["nft_id"]-1]["name"] ?>">
					<div class="bid">
						<div class="bid_part">
							<p class="bold"><?php echo $weeklyShownAuctions[0]["name"] ?></p>
						</div>
						<div class="bid_part">
							<img src="img/eth.svg" alt="Ethereum">
							<p id="value" class="bold"><?php
								$sql = "SELECT `user_id`, `auction_id`, `value` FROM `users_bid` WHERE auction_id=".$weeklyShownAuctions[0]["id"]." ORDER BY value DESC LIMIT 1";
								$pre = $db->prepare($sql);
								$pre->execute();
								$showcaseData = $pre->fetch(PDO::FETCH_ASSOC);
								echo $showcaseData["value"] ?>ETH</p>
						</div>
					</div>
					<div class="bid_bottom">
						<div class="bid_time">
							<p class="gray">Fin dans</p>
							<div class="time">
								<img src="img/clock.svg" alt="Temps restant">
								<p id="timeleft_1" class="bold">00:00:00</p>
							</div>
						</div>
						<div id="gallery_1_bid_button">
							<button onclick="showBidUI(<?php echo (isset($_SESSION['user'])) ?>, 'gallery1')">Placer une enchère</button>
						</div>
					</div>
					<div id="gallery_1_bid_info" class="bid_info gallery_container">
						<p class="name"><?php echo $NFTs[$weeklyShownAuctions[0]["nft_id"]-1]["name"] ?></p>
						<p class="description"><?php echo $NFTs[$weeklyShownAuctions[0]["nft_id"]-1]["description"] ?></p>
						<p class="author"><span>Crée par:</span> <?php echo $NFTs[$weeklyShownAuctions[0]["nft_id"]-1]["firstname"]." ".$NFTs[$weeklyShownAuctions[0]["nft_id"]-1]["lastname"] ?></p>
						<form action="actions/bet.php" method="post">
							<label>Place your prize</label>
							<input type="hidden" name="auction_id" value="<?php echo $NFTs[$weeklyShownAuctions[0]["id"]-1]["id"] ?>">
							<input type="hidden" name="user_id" value="<?php echo $_SESSION['user']['id'] ?>">
							<input type="number" step="0.01" name="price">
							<input type="submit" value="Poser l'enchère">
						</form>
					</div>
				</div>
				<div class="container">
					<img src="img/NFTs/<?php echo $weeklyShownAuctions[1]["path"] ?>.webp" alt="<?php echo $NFTs[$weeklyShownAuctions[1]["nft_id"]-1]["name"] ?>">
					<div class="bid">
						<div class="bid_part">
							<p class="bold"><?php echo $weeklyShownAuctions[1]["name"] ?></p>
						</div>
						<div class="bid_part">
							<img src="img/eth.svg" alt="Ethereum">
							<p id="value" class="bold"><?php
								$sql = "SELECT `user_id`, `auction_id`, `value` FROM `users_bid` WHERE auction_id=".$weeklyShownAuctions[1]["id"]." ORDER BY value DESC LIMIT 1";
								$pre = $db->prepare($sql);
								$pre->execute();
								$showcaseData = $pre->fetch(PDO::FETCH_ASSOC);
								echo $showcaseData["value"] ?>ETH</p>
						</div>
					</div>
					<div class="bid_bottom">
						<div class="bid_time">
							<p class="gray">Fin dans</p>
							<div class="time">
								<img src="img/clock.svg" alt="Temps restant">
								<p id="timeleft_2" class="bold">00:00:00</p>
							</div>
						</div>
						<div id="gallery_2_bid_button">
							<button onclick="showBidUI(<?php echo (isset($_SESSION['user'])) ?>, 'gallery2')">Placer une enchère</button>
						</div>
					</div>
					<div id="gallery_2_bid_info" class="bid_info gallery_container">
						<p class="name"><?php echo $NFTs[$weeklyShownAuctions[1]["nft_id"]-1]["name"] ?></p>
						<p class="description"><?php echo $NFTs[$weeklyShownAuctions[1]["nft_id"]-1]["description"] ?></p>
						<p class="author"><span>Crée par:</span> <?php echo $NFTs[$weeklyShownAuctions[1]["nft_id"]-1]["firstname"]." ".$NFTs[$weeklyShownAuctions[1]["nft_id"]-1]["lastname"] ?></p>
						<form action="actions/bet.php" method="post">
							<label>Place your prize</label>
							<input type="hidden" name="auction_id" value="<?php echo $NFTs[$weeklyShownAuctions[1]["id"]-1]["id"] ?>">
							<input type="hidden" name="user_id" value="<?php echo $_SESSION['user']['id'] ?>">
							<input type="number" step="0.01" name="price">
							<input type="submit" value="Poser l'enchère">
						</form>
					</div>
				</div>
				<div class="container">
					<img src="img/NFTs/<?php echo $weeklyShownAuctions[2]["path"] ?>.webp" alt="<?php echo $NFTs[12]["name"] ?>">
					<div class="bid">
						<div class="bid_part">
							<p class="bold"><?php echo $weeklyShownAuctions[2]["name"] ?></p>
						</div>
						<div class="bid_part">
							<img src="img/eth.svg" alt="Ethereum">
							<p id="value" class="bold"><?php
								$sql = "SELECT `user_id`, `auction_id`, `value` FROM `users_bid` WHERE auction_id=".$weeklyShownAuctions[2]["id"]." ORDER BY value DESC LIMIT 1";
								$pre = $db->prepare($sql);
								$pre->execute();
								$showcaseData = $pre->fetch(PDO::FETCH_ASSOC);
								echo $showcaseData["value"] ?>ETH</p>
						</div>
					</div>
					<div class="bid_bottom">
						<div class="bid_time">
							<p class="gray">Fin dans</p>
							<div class="time">
								<img src="img/clock.svg" alt="Temps restant">
								<p id="timeleft_3" class="bold">00:00:00</p>
							</div>
						</div>
						<div id="gallery_3_bid_button">
							<button onclick="showBidUI(<?php echo (isset($_SESSION['user'])) ?>, 'gallery3')">Placer une enchère</button>
						</div>
					</div>
					<div id="gallery_3_bid_info" class="bid_info gallery_container">
						<p class="name"><?php echo $NFTs[12]["name"] ?></p>
						<p class="description"><?php echo $NFTs[12]["description"] ?></p>
						<p class="author"><span>Crée par:</span> <?php echo $NFTs[12]["firstname"]." ".$NFTs[12]["lastname"] ?></p>
						<form action="actions/bet.php" method="post">
							<label>Place your prize</label>
							<input type="hidden" name="auction_id" value="<?php echo $weeklyShownAuctions[2]["id"] ?>">
							<input type="hidden" name="user_id" value="<?php echo $_SESSION['user']['id'] ?>">
							<input type="number" step="0.01" name="price">
							<input type="submit" value="Poser l'enchère">
						</form>
					</div>
				</div>
			</div>
			<div class="glow"></div>
		</div>
		<div class="create">
			<div class="text">
				<div class="text">
					<h2><?php echo $data['title_create'] ?></h2>
					<p><?php echo $data['text_create'] ?></p>
				</div>
				<div class="buttons">
					<a class="button1"><?php echo $data['button_create'] ?></a>
					<a class="button2"><?php echo $data['text_second_button'] ?></a>
				</div>
			</div>
			<div class="images">
				<img class="i1" src="img/NFTs/<?php echo $NFTs[$dataNFTs[3]["id"]-1]["path"] ?>.webp" alt="NFT <?php echo $NFTs[$dataNFTs[3]["id"]-1]["path"] ?>">
				<img class="i2" src="img/NFTs/<?php echo $NFTs[$dataNFTs[4]["id"]-1]["path"] ?>.webp" alt="NFT <?php echo $NFTs[$dataNFTs[4]["id"]-1]["path"] ?>">
			</div>
			<div class="glow"></div>
		</div>
		<div class="popular">
			<div class="title">
				<h2><?php echo $data['title_popular'] ?></h2>
				<a><?php echo $data['button_popular'] ?></a>
			</div>
			<div class="gallery">
				<div class="container-1">
					<img class="i1" src="img/NFTs/<?php echo $NFTs[$dataNFTs[7]["id"]-1]["path"] ?>.webp" alt="NFT <?php echo $NFTs[$dataNFTs[7]["id"]-1]["name"] ?>">
					<div class="creator-data">
						<img src="img/authors/<?php echo $NFTs[$dataNFTs[7]["id"]-1]["avatar"] ?>.webp" alt="Avatar">
						<div class="creator-text">
							<p class="key">Créateur</p>
							<p class="field"><?php echo $NFTs[$dataNFTs[7]["id"]-1]["firstname"]." ".$NFTs[$dataNFTs[7]["id"]-1]["lastname"] ?></p>
						</div>
					</div>
				</div>
				<div class="container-2">
					<img class="i2" src="img/NFTs/<?php echo $NFTs[$dataNFTs[8]["id"]-1]["path"] ?>.webp" alt="NFT <?php echo $NFTs[$dataNFTs[8]["id"]-1]["name"] ?>">
					<div class="creator-data">
						<img src="img/authors/<?php echo $NFTs[$dataNFTs[8]["id"]-1]["avatar"] ?>.webp", alt="Avatar">
						<div class="creator-text">
							<p class="key">Créateur</p>
							<p class="field"><?php echo $NFTs[$dataNFTs[8]["id"]-1]["firstname"]." ".$NFTs[$dataNFTs[8]["id"]-1]["lastname"] ?></p>
						</div>
					</div>
				</div>
				<div class="container-3">
					<img class="i3" src="img/NFTs/<?php echo $NFTs[$dataNFTs[9]["id"]-1]["path"] ?>.webp" alt="NFT <?php echo $NFTs[$dataNFTs[9]["id"]-1]["name"] ?>">
					<div class="creator-data">
						<img src="img/authors/<?php echo $NFTs[$dataNFTs[9]["id"]-1]["avatar"] ?>.webp" alt="Avatar">
						<div class="creator-text">
							<p class="key">Créateur</p>
							<p class="field"><?php echo $NFTs[$dataNFTs[9]["id"]-1]["firstname"]." ".$NFTs[$dataNFTs[9]["id"]-1]["lastname"] ?></p>
						</div>
					</div>
				</div>
				<div class="container-4">
					<img class="i4" src="img/NFTs/<?php echo $NFTs[$dataNFTs[10]["id"]-1]["path"] ?>.webp" alt="NFT <?php echo $NFTs[$dataNFTs[10]["id"]-1]["name"] ?>">
					<div class="creator-data">
						<img src="img/authors/<?php echo $NFTs[$dataNFTs[10]["id"]-1]["avatar"] ?>.webp" alt="Avatar">
						<div class="creator-text">
							<p class="key">Créateur</p>
							<p class="field">Abraham Zack</p>
						</div>
					</div>
				</div>
				<div class="container-5">
					<img class="i5" src="img/NFTs/<?php echo $NFTs[$dataNFTs[11]["id"]-1]["path"] ?>.webp"  alt="NFT <?php echo $NFTs[$dataNFTs[11]["id"]-1]["name"] ?>">
					<div class="creator-data special">
						<img src="img/authors/<?php echo $NFTs[$dataNFTs[11]["id"]-1]["avatar"] ?>.webp" alt="Avatar">
						<div class="creator-text">
							<p class="key">Créateur</p>
							<p class="field"><?php echo $NFTs[$dataNFTs[11]["id"]-1]["firstname"]." ".$NFTs[$dataNFTs[11]["id"]-1]["lastname"] ?></p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="contact">
			<div class="images">
				<img class="underImage" src="img/NFTs/<?php echo $NFTs[$dataNFTs[1]["id"]-1]["path"] ?>.webp" alt="NFT <?php echo $NFTs[$dataNFTs[1]["id"]-1]["name"] ?>">
				<img class="overImage" src="img/NFTs/<?php echo $NFTs[$dataNFTs[2]["id"]-1]["path"] ?>.webp" alt="NFT <?php echo $NFTs[$dataNFTs[2]["id"]-1]["name"] ?>">
			</div>
			<div class="text">
				<div class="notForm">
					<h2><?php echo $data['title_newsletter'] ?></h2>
					<p><?php echo $data['text_newsletter'] ?></p>
				</div>
				<div class="isForm">
					<form>
						<div class="email">
    						<input type="email" name="email" id="email" placeholder="Votre e-mail" required>
    					</div>
    					<input type="submit" value="S’inscrire">
					</form>
				</div>
			</div>
			<div class="glow"></div>
		</div>
		<?php require_once("components/footer.php") ?>
		<script src="script.js"></script>
	</div>
</body>
</html>