<?php
session_start();
$usuarios = [
    'tnc' => 'tncorporation20025#',
];
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
if (isset($usuarios[$username]) && $usuarios[$username] === $password) {
    $_SESSION['username'] = $username;
    header('Location: index.php');
    exit;
} else {
    echo "<script> window.location.href = 'https://www.roblox.com/pt/home';</script>";
    exit;
}
?>
