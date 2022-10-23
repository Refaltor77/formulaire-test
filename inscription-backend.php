<?php

function checkMdp($mdp) {
    $maj = preg_match('@[A-Z]@', $mdp);
    $min = preg_match('@[a-z]@', $mdp);
    $numbers = preg_match('@[0-9]@', $mdp);
    if(!$maj || !$min || !$numbers || strlen($mdp) < 8) {
        return false;
    } else return true;
}


$name = htmlspecialchars($_POST['name']);
$surname = htmlspecialchars($_POST['surname']);
$email = htmlspecialchars($_POST['email']);
$mdp = htmlspecialchars($_POST['mdp']);
$mdpConfirmed = htmlspecialchars($_POST['mdp-confirm']);
$lang = htmlspecialchars($_POST['lang']);
$pays = htmlspecialchars($_POST['pays']);

if ($mdp !== $mdpConfirmed) {
    header('Location: inscription.php?error=true&type=mdp');
    return;
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    header('Location: inscription.php?error=true&type=email');
    return;
}

if (!checkMdp($mdp)) {
    header('Location: inscription.php?error=true&type=mdpstrong');
    return;
}

$mdp = password_hash($mdp, PASSWORD_ARGON2I);
$pdo = new PDO('mysql:host=127.0.0.1;dbname=test-form', 'root', '');
$select = $pdo->prepare("SELECT `email` FROM `users` WHERE `email` = :email");
$select->bindParam(':email', $email);
$select->execute();
$fetch = $select->fetch(MYSQLI_ASSOC);
if (isset($fetch['email'])) {
    header('Location: inscription.php?error=true&type=emailah');
    return;
}



$pdo->query("CREATE TABLE IF NOT EXISTS `users` (`name` VARCHAR(255), `surname` VARCHAR(255), `email` VARCHAR(255), `mdp` TEXT, `lang` VARCHAR(255), `pays` VARCHAR(255));");
$prepare = $pdo->prepare("INSERT INTO `users` (`name`, `surname`, `email`, `mdp`, `lang`, `pays`) VALUES (:name, :surname, :email, :mdp, :lang, :pays);");
$prepare->bindParam(':name', $name);
$prepare->bindParam(':surname', $surname);
$prepare->bindParam(':email', $email);
$prepare->bindParam(':mdp', $mdp);
$prepare->bindParam(':lang', $lang);
$prepare->bindParam(':pays', $pays);
$prepare->execute();

header('Location: connexion.php');