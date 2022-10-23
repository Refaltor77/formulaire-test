<?php
session_start();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="post" action="connexion-backend.php">
        <?php
        if (isset($_GET['error'])) {
            switch ($_GET['type']) {
                case "mdp":
                    echo "<span style='color: red'>Votre mot de passe est incorect</span>";
                    break;
                case "user":
                    echo "<span style='color: red'>Le compte n'existe pas</span>";
                    break;
            }
        }
        ?>
        <h1>Connexion</h1>
        <input type="email" name="email" placeholder="Votre email" required>
        <input type="password" name="mdp" placeholder="Votre mot de passe">
        <button>Se connecter</button>
    </form>
</body>
</html>
