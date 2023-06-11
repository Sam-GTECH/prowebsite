<?php
    session_start();
    // Souvent on identifie cet objet par la variable $conn ou $db
    $db = new PDO(
        'mysql:host=localhost;dbname=nft_website;charset=utf8',
        'root',
        'root'
    );
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
?>