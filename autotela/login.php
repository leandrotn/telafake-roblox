<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:rgba(17, 16, 16, 0.92);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: #121212;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 320px;
        }
        .login-container h2 {
            margin-bottom: 20px;
            font-size: 22px;
            font-weight: bold;
            text-align: center;
            color: #333;
        }
        .login-container form {
            display: flex;
            flex-direction: column;
        }
        .login-container input {
            width: 96%;
            padding:  02%;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .login-container button:hover {
            background-color:rgb(12, 12, 12); 
        }
   
    </style>
</head>
<body>
    <div class="login-container">
        <h2>ROUBLOX Login</h2>
        <form action="process_login.php" method="POST">
            <input type="text" name="username" placeholder="Usuário" required>
            <input type="password" name="password" placeholder="Senha" required>
            <button type="submit">Entrar</button>
        </form>
    </div>
    <footer style="position: fixed; bottom: 0; left: 0; width: 100%; text-align: center; margin-top: 20px; font-size: 14px; color: #888; background-color: #121212; padding: 10px;">
    Desenvolvido by <strong>LEANDROTN</strong>, CEO Owner from <strong>TNCorporation Brazil</strong>
</footer>

</body>
</html>
