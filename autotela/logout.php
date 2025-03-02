<?php
session_start();
session_unset(); 
session_destroy(); 

if (!isset($_SESSION['username'])) {
    header('Location: https://www.roblox.com/pt/home');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="refresh" content="0;url=login.php">
    <script>
        window.location.href = 'login.php';
    </script>
</head>
<body>
    Redirecionando para a página de login...
</body>
</html>

