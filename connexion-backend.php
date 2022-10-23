<?php

# je met les données uniquement ici comme sa apres je dirige vers le "dashboard"
session_start();


$email = $_POST['email'];
$mdp = $_POST['mdp'];

$pdo = new PDO('mysql:host=127.0.0.1;dbname=test-form', 'root', '');
$select = $pdo->prepare("SELECT * FROM `users` WHERE `email` = :email;");
$select->bindParam(':email', $email);
$select->execute();
$result = $select->fetch(MYSQLI_ASSOC);

if (isset($result['email'])) {
    $mdpHash = $result['mdp'];
    if (!password_verify($mdp, $mdpHash)) {
        header('Location: connexion.php?error=true&type=mdp');
        return;
    }

    $_SESSION['connected'] = true;
    $_SESSION['email'] = $email;
    $_SESSION['name'] = $result['name'];
    $_SESSION['surname'] = $result['surname'];
    header('Location: dashboard.php');
} else {
    header('Location: connexion.php?error=true&type=user');
}