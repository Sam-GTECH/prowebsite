<!DOCTYPE html>
<html>
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

	$query= "SELECT nft_id, user_id, name, path, price, enddate, isMainShown, isWeeklyShown FROM auctions JOIN nfts ON auctions.nft_id = nfts.id";
	$predata = $db->prepare($query);
	$predata->execute();
	$dataAuctions = $predata->fetchAll(PDO::FETCH_ASSOC);

	$query= "SELECT nfts.id, path, firstname, lastname, avatar FROM nfts JOIN users ON nfts.user_id = users.id;";
	$prenft = $db->prepare($query);
	$prenft->execute();
	$NFTs = $prenft->fetchAll(PDO::FETCH_ASSOC);

	$showcasedAuction = NULL;
	$weeklyShownAuctions = array();

	//var_dump($dataAuctions)
	foreach ($dataAuctions as $key => $value) {
		if ($value["isMainShown"] && is_null($showcasedAuction))
			$showcasedAuction = $value;
		if ($value["isWeeklyShown"] && count($weeklyShownAuctions)<3)
			array_push($weeklyShownAuctions, $value);
	}

	//echo var_dump($showcasedAuction);
	//echo var_dump($weeklyShownAuctions);

	//echo var_dump($NFTs);
	//echo var_dump($dataNFTs);

	echo isset($_SESSION["user"])?"A user is connected":"Anon";
	echo var_dump($_SESSION['user']);
?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script>
		const showcaseDate = "<?php echo $showcasedAuction["enddate"] ?>"
		const weeklyDates = [<?php echo '"'.$weeklyShownAuctions[0]["enddate"].'"'.",".'"'.$weeklyShownAuctions[1]["enddate"].'"'.",".'"'.$weeklyShownAuctions[2]["enddate"].'"' ?>]
	</script>
	<script src="script.js"></script>
	<link href="font/fontawesome/css/fontawesome.min.css" rel="stylesheet">
  	<link href="font/fontawesome/css/brands.min.css" rel="stylesheet">
  	<link href="font/fontawesome/css/solid.min.css" rel="stylesheet">
	<title><?php echo $data['title_site'] ?></title>
</head>
<body>
	<div id="bg">
		<img src="img/BG.png"/>
	</div>
	<nav>
		<div id ="navbar">
			<a id="focus" href="marketplace">Marketplace</a>
			<a href="artists">Artistes</a>
			<a href="community">Communauté</a>
			<a href="collections">Collections</a>
		</div>
		<div id="right_nav">
			<a id="contact-button">Contact</a>
			<?php if (isset($_SESSION['user'])) { ?>
				<a href="userpage"><img src="img/authors/<?php echo $_SESSION['user']["avatar"] ?>.png"></a>
			<?php } ?>
		</div>
	</nav>
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
				<img src="img/NFTs/<?php echo $showcasedAuction["path"] ?>.png"/>
				<div class="glow"></div>
				<div class="container bid_square">
					<div class="bid">
						<div class="bid_part">
							<p class="colorPri">Fin dans</p><p id="timeleft" class="bold">00:00:00</p>
						</div>
						<div class="bid_part">
							<p class="colorPri">Enchère actuelle</p><p id="value" class="bold"><?php echo $showcasedAuction["price"] ?>ETH</p>
						</div>
					</div>
					<div class="bid_button">
						<button onclick="showBidUI(<?php echo (isset($_SERVER['user'])?1:0) ?>)">Placer une enchère</button>
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
					<img src="img/NFTs/<?php echo $weeklyShownAuctions[0]["path"] ?>.png">
					<div class="bid">
						<div class="bid_part">
							<p class="bold"><?php echo $weeklyShownAuctions[0]["name"] ?></p>
						</div>
						<div class="bid_part">
							<img src="img/eth.svg">
							<p id="value" class="bold"><?php echo $weeklyShownAuctions[0]["price"] ?>ETH</p>
						</div>
					</div>
					<div class="bid_bottom">
						<div class="bid_time">
							<p class="gray">Fin dans</p>
							<div class="time">
								<img src="img/clock.svg">
								<p id="timeleft" class="bold">00:00:00</p>
							</div>
						</div>
						<div>
							<button>Placer une enchère</button>
						</div>
					</div>
				</div>
				<div class="container">
					<img src="img/NFTs/<?php echo $weeklyShownAuctions[1]["path"] ?>.png">
					<div class="bid">
						<div class="bid_part">
							<p class="bold"><?php echo $weeklyShownAuctions[1]["name"] ?></p>
						</div>
						<div class="bid_part">
							<img src="img/eth.svg">
							<p id="value" class="bold"><?php echo $weeklyShownAuctions[1]["price"] ?>ETH</p>
						</div>
					</div>
					<div class="bid_bottom">
						<div class="bid_time">
							<p class="gray">Fin dans</p>
							<div class="time">
								<img src="img/clock.svg">
								<p id="timeleft" class="bold">00:00:00</p>
							</div>
						</div>
						<div>
							<button>Placer une enchère</button>
						</div>
					</div>
				</div>
				<div class="container">
					<img src="img/NFTs/<?php echo $weeklyShownAuctions[2]["path"] ?>.png">
					<div class="bid">
						<div class="bid_part">
							<p class="bold"><?php echo $weeklyShownAuctions[2]["name"] ?></p>
						</div>
						<div class="bid_part">
							<img src="img/clock.svg">
							<p id="value" class="bold"><?php echo $weeklyShownAuctions[2]["price"] ?>ETH</p>
						</div>
					</div>
					<div class="bid_bottom">
						<div class="bid_time">
							<p class="gray">Fin dans</p>
							<div class="time">
								<img src="img/clock.svg">
								<p id="timeleft" class="bold">00:00:00</p>
							</div>
						</div>
						<div>
							<button>Placer une enchère</button>
						</div>
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
				<img class="i1" src="img/NFTs/<?php echo $NFTs[$dataNFTs[3]["id"]-1]["path"] ?>.png">
				<img class="i2" src="img/NFTs/<?php echo $NFTs[$dataNFTs[4]["id"]-1]["path"] ?>.png">
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
					<img class="i1" src="img/NFTs/<?php echo $NFTs[$dataNFTs[7]["id"]-1]["path"] ?>.png">
					<div class="creator-data">
						<img src="img/authors/<?php echo $NFTs[$dataNFTs[7]["id"]-1]["avatar"] ?>.png">
						<div class="creator-text">
							<p class="key">Créateur</p>
							<p class="field"><?php echo $NFTs[$dataNFTs[7]["id"]-1]["firstname"]." ".$NFTs[$dataNFTs[7]["id"]-1]["lastname"] ?></p>
						</div>
					</div>
				</div>
				<div class="container-2">
					<img class="i2" src="img/NFTs/<?php echo $NFTs[$dataNFTs[8]["id"]-1]["path"] ?>.png">
					<div class="creator-data">
						<img src="img/authors/<?php echo $NFTs[$dataNFTs[8]["id"]-1]["avatar"] ?>.png">
						<div class="creator-text">
							<p class="key">Créateur</p>
							<p class="field"><?php echo $NFTs[$dataNFTs[8]["id"]-1]["firstname"]." ".$NFTs[$dataNFTs[8]["id"]-1]["lastname"] ?></p>
						</div>
					</div>
				</div>
				<div class="container-3">
					<img class="i3" src="img/NFTs/<?php echo $NFTs[$dataNFTs[9]["id"]-1]["path"] ?>.png">
					<div class="creator-data">
						<img src="img/authors/<?php echo $NFTs[$dataNFTs[9]["id"]-1]["avatar"] ?>.png">
						<div class="creator-text">
							<p class="key">Créateur</p>
							<p class="field"><?php echo $NFTs[$dataNFTs[9]["id"]-1]["firstname"]." ".$NFTs[$dataNFTs[9]["id"]-1]["lastname"] ?></p>
						</div>
					</div>
				</div>
				<div class="container-4">
					<img class="i4" src="img/NFTs/<?php echo $NFTs[$dataNFTs[10]["id"]-1]["path"] ?>.png">
					<div class="creator-data">
						<img src="img/authors/<?php echo $NFTs[$dataNFTs[10]["id"]-1]["avatar"] ?>.png">
						<div class="creator-text">
							<p class="key">Créateur</p>
							<p class="field">Abraham Zack</p>
						</div>
					</div>
				</div>
				<div class="container-5">
					<img class="i5" src="img/NFTs/<?php echo $NFTs[$dataNFTs[11]["id"]-1]["path"] ?>.png">
					<div class="creator-data special">
						<img src="img/authors/<?php echo $NFTs[$dataNFTs[11]["id"]-1]["avatar"] ?>.png">
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
				<img class="underImage" src="img/NFTs/<?php echo $NFTs[$dataNFTs[1]["id"]-1]["path"] ?>.png">
				<img class="overImage" src="img/NFTs/<?php echo $NFTs[$dataNFTs[2]["id"]-1]["path"] ?>.png">
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
	</div>
</body>
</html>