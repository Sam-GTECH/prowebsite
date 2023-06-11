<?php
require_once("../components/config.php");

echo var_dump($_POST);

if (empty($_POST['firstname']) || empty($_POST["lastname"])) {
	$_SESSION['error'] = "Veuillez rentrer votre nom et prénom !";
} else if (empty($_POST["email"])) {
	$_SESSION["error"] = "Veuillez rentrer un email valide !";
} else if (empty($_POST["password"])) {
	$_SESSION["error"] = "Veuillez rentrer un mot de passe !";
}

if (isset($_SESSION['error'])) {
	echo "\n\nReturned error \"".$_SESSION["error"]."\"";
	header("Location:../login.php");
	die();
}

$sql = "INSERT INTO users(avatar, firstname, lastname, email, password, admin) VALUES(:avatar,:firstname, :lastname, :email, sha1(:password), 0)";
$dataBinded=array(
	':avatar' => "default",
    ':firstname'   => $_POST['firstname'],
    ':lastname'   => $_POST['lastname'],
    ':email'=> $_POST['email'],
    ':password'=> "h%%%£o£££*µ&r12FFFn__ç1ày@HELP'.".$_POST['password'],
);
$pre = $db->prepare($sql);
$pre->execute($dataBinded);

header("Location:../index.php")
?>