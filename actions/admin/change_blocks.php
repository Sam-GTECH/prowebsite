<?php
require_once("../../components/config.php");

if (!isset($_SESSION['user']) || !$_SESSION['user']['admin']) {
	header("Location:../../index.php");
	die();
}

//var_dump($_POST)

$HTML = [
    '[color]' => '<span>',
    '[/color]' => '</span>',
    '[nextline]' => '<br>'
];

foreach ($_POST as $key => $value) {
	$_POST[$key] = str_replace(array_keys($HTML), array_values($HTML), $value);
}

var_dump($_POST);

$query = "UPDATE `website_blocks` SET 
		`title_main`=:title_main,
		`text_main`=:text_main,
		`button_main`=:button_main,
		`title_marketplace`=:title_marketplace,
		`button_marketplace`=:button_marketplace,
		`title_create`=:title_create,
		`text_create`=:text_create,
		`button_create`=:button_create,
		`title_popular`=:title_popular,
		`button_popular`=:button_popular,
		`title_newsletter`=:title_newsletter,
		`text_newsletter`=:text_newsletter,
		`text_contact`=:text_contact,
		`facebook_contact`=:facebook_contact,
		`mail_contact`=:mail_contact,
		`twitter_contact`=:twitter_contact,
		`linkedin_contact`=:linkedin_contact,
		`text_second_button`=:text_second_button,
		`title_site`=:title_site,
		`description_site`=:description_site
		WHERE 1";
$dataBinded=array(
	':title_main' => $_POST['title_main'],
	':text_main' => $_POST['text_main'],
	':button_main' => $_POST['button_main'],
	':title_marketplace' => $_POST['title_marketplace'],
	':button_marketplace' => $_POST['button_marketplace'],
	':title_create' => $_POST['title_create'],
	':text_create' => $_POST['text_create'],
	':button_create' => $_POST['button_create'],
	':title_popular' => $_POST['title_popular'],
	':button_popular' => $_POST['button_popular'],
	':title_newsletter' => $_POST['title_newsletter'],
	':text_newsletter' => $_POST['text_newsletter'],
	':text_contact' => $_POST['text_contact'],
	':facebook_contact' => $_POST['facebook_contact'],
	':mail_contact' => $_POST['mail_contact'],
	':twitter_contact' => $_POST['twitter_contact'],
	':linkedin_contact' => $_POST['linkedin_contact'],
	':text_second_button' => $_POST['text_second_button'],
	':title_site' => $_POST['title_site'],
	':description_site' => $_POST['description_site']
);
$pre = $db->prepare($query);
$pre->execute($dataBinded);

header("Location:../../userpage.php")
?>