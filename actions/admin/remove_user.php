<?php
require_once("../../components/config.php");

if (!isset($_SESSION['user']) || !$_SESSION['user']['admin']) {
	header("Location:../../index.php");
	die();
}

var_dump($_POST);

$sql = "DELETE FROM users WHERE id =".$_POST['id'];
$pre = $db->prepare($sql);
$pre->execute();

if ($_POST["id"]==$_SESSION["user"]["id"]){
	unset($_SESSION["user"]);
}

header("Location:../../userpage.php")

?>