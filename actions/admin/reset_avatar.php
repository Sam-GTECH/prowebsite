<?php
require_once("../../components/config.php");

if (!isset($_SESSION['user']) || !$_SESSION['user']['admin']) {
	header("Location:../../index.php");
	die();
}

var_dump($_POST);

$sql = "UPDATE users SET avatar = 'default' WHERE id=".$_POST['id'];
$pre = $db->prepare($sql);
$pre->execute();

header("Location:../../userpage.php")

?>