<?php
session_start();
unset($_SESSION['id']);
unset($_SESSION['name']);
unset($_SESSION['account']);
unset($_SESSION['login']);
header("Location: index.php");
?>
