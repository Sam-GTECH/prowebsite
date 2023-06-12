<?php
require_once("../components/config.php");

if (!isset($_SESSION['user']) || $_SESSION['user']["id"] != $_POST['id']) {
	header("Location:../userpage.php");
	die();
}

date_default_timezone_set('Europe/Paris');

$filename = uniqid() . '_' . $_FILES['image']['name'];
if (move_uploaded_file($_FILES['image']['tmp_name'], "../img/NFTs/".$filename)) {
	$sql = "INSERT INTO nfts(user_id, name, description, path, creation_date) VALUES(:user_id, :name, :description, :path, :creation_date)";
	$dataBinded=array(
		':user_id' => $_POST['id'],
	    ':name'   => $_POST['name'],
	    ':description'   => isset($_POST['description'])?$_POST['description']:"No description provided",
	    ':path'=> pathinfo($filename)["filename"],
	    ':creation_date'=> date("Y-m-d H:i:s"),
	);
	$pre = $db->prepare($sql);
	$pre->execute($dataBinded);
	echo("Success! and also: ".date("Y-m-d H:i:s"));
} else {
	$_SESSION['error'] = "An error has occured when uploading the file. Try again later.";
}

header("Location:../userpage.php");
?>