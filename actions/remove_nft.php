<?php
require_once("../components/config.php");

if (!isset($_SESSION['user'])) {
	header("Location:../login.php");
	die();
}

$query= "SELECT user_id FROM nfts WHERE id=".$_POST['id'];
$predata = $db->prepare($query);
$predata->execute();
$checkUser = $predata->fetch(PDO::FETCH_ASSOC);

var_dump($checkUser);
$allowAction = 0;
if (isset($checkUser)) {
	if ($checkUser["user_id"]==$_POST['id']) {
		$allowAction = 1;
	} else {
		if ($_SESSION['user']['admin']) {
			$allowAction = 1;
		}
	}
}

if (!$allowAction) {
	header("Location:../userpage.php");
	die();
}

$sql = "DELETE FROM nfts WHERE id =".$_POST['id'];
$pre = $db->prepare($sql);
$pre->execute();

header("Location:../userpage.php");
?>