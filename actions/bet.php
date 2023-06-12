<?php
require_once("../components/config.php");

if (!isset($_SESSION['user']) || $_SESSION['user']["id"] != $_POST['user_id']) {
	header("Location:../index.php");
	die();
}

var_dump($_POST);

$sql = "INSERT INTO users_bid(user_id, auction_id, value) VALUES (:user_id, :auction_id, :value)";
$dataBinded=array(
	':user_id'    => $_POST['user_id'],
    ':auction_id' => $_POST['auction_id'],
    ':value'      => $_POST['price'],
);
$pre = $db->prepare($sql);
$pre->execute($dataBinded);

$_SESSION['message'] = "Félicitations pour cette action! Voudriez-vous la <a href='https://twitter.com/intent/tweet?text=J%27ai%20pos%C3%A9%20une%20ench%C3%A8re%20sur%20NFT%20Marketplace!%20Esp%C3%A8rons%20que%20je%20gagne%20les%20ench%C3%A8res!'>partager</a>?";

header("Location:../index.php");
?>