<?php

session_start();

if ($_SESSION['connected']) {
    session_destroy();
}

header('Location: inscription.php');