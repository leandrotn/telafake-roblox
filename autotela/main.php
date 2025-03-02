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
            color:rgb(8, 245, 40); 
        }
      
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input, textarea, select {
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
        }
        button:hover {
            background-color: #0056b3;
        }
        .thumbnail-container {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        .thumbnail {
            display: inline-block;
            cursor: pointer;
            border: 2px solid transparent;
        }
        .thumbnail img {
            max-width: 100px;
            border-radius: 5px;
        }
        .thumbnail.selected {
            border-color: #007BFF;
        }
    </style>
</head>
<body>
<h1 style="color:rgb(8, 245, 40); text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); margin-bottom: 0; text-align: center;">
    CONFIG GAMERPASS
</h1>
<br>
    <form id="configForm">
    </form>
	<div style="display: flex; gap: 10px;">
    <button style="border-radius: 5px;" onclick="setModo(0)">0 PC</button>
    <button style="border-radius: 5px;" onclick="setModo(1)">1 MOBILE</button>
</div>
<br></br>
 <div style="display: flex; gap: 10px; align-items: center;">
  <button style="border-radius: 5px;" onclick="saveConfig()" style="padding: 10px 20px; font-weight: bold;">Salvar Alterações</button>
  <a href="logout.php" 
     style="background-color: red; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; text-align: center;">
    SAIR
  </a>
</div>

    <script>
    function setModo(value) {
        const modoInput = document.querySelector('input[name="modo"]');
        if (modoInput) {
            modoInput.value = value;
        } else {
        }
    }
</script>

    <script>
        const apiUrl = 'save_config.php';
        const fotolugapassImages = [
            "https://t1.rbxcdn.com/180DAY-46a280d1876d4572c2872d1887e25dd7",
            "https://t5.rbxcdn.com/180DAY-4ef1a021f016df65e7e3b16c7c3a6172",
            "https://t5.rbxcdn.com/180DAY-9ef27ad208a74259c6696b52e06cc334",
            "https://t2.rbxcdn.com/180DAY-dfa851655fd93a0b056880792a30824d",
            "https://t7.rbxcdn.com/180DAY-fad9600a6ea56fbcd48681540dbe11f8",
            "https://t7.rbxcdn.com/180DAY-07263f0337451345b06d7e953e77b090",
            "https://t6.rbxcdn.com/180DAY-c1611195b4be5d892c716ef407cba94e",
            "https://t7.rbxcdn.com/180DAY-1c60b8e5ddae72fdb147a85af4d1ace0",
            "https://t1.rbxcdn.com/180DAY-1ec0a44b5f06c5e4bed26988a8baa8b7",
            "https://t6.rbxcdn.com/180DAY-3b49af0e96b2a791c935d284a59c153a",
            "https://t0.rbxcdn.com/180DAY-6787a932da0e9cecb9b5a4ad5abc6003"
        ];

        async function fetchConfig() {
    try {
        const response = await fetch(apiUrl);
        const config = await response.json();

        const form = document.getElementById('configForm');
        for (const key in config) {
            const value = config[key];

            const formGroup = document.createElement('div');
            formGroup.className = 'form-group';

            const label = document.createElement('label');
            label.textContent = key;

            let input;
            if (key === 'DESCRIÇÃO') {
                input = document.createElement('textarea');
                input.value = value;
                input.id = 'descricaoInput';

           
                input.addEventListener('input', () => {
                    const descricaoValue = input.value.trim();
                    const elementActiveInput = document.getElementById('elementActiveInput');
                    if (descricaoValue !== "") {
                        elementActiveInput.value = "Descri&#xE7;&#xE3;o";
                    } else {
                        elementActiveInput.value = "";
                    }
                });
            } else if (key === 'element_active') {
                
                input = document.createElement('input');
                input.type = 'hidden';
                input.value = value;
                input.id = 'elementActiveInput';  
            } else {
                input = document.createElement('input');
                input.type = 'text';
                input.value = value;
            }
            input.name = key;

            
            if (key === 'FOTO DO PASSE') {
                input.setAttribute('id', 'fotopassInput');

                const thumbnailDiv = document.createElement('div');
                thumbnailDiv.className = 'thumbnail';
                thumbnailDiv.title = 'Selecionar esta foto';

                const thumbnailImg = document.createElement('img');
                thumbnailImg.src = 'https://tr.rbxcdn.com/180DAY-2cd7f246a3a03278f469a272a979a003/420/420/Image/Png/noFilter';

                thumbnailDiv.appendChild(thumbnailImg);
                thumbnailDiv.onclick = () => {
                    document.querySelectorAll('.thumbnail').forEach(el => el.classList.remove('selected'));
                    thumbnailDiv.classList.add('selected');
                    input.value = thumbnailImg.src;
                };

                formGroup.appendChild(thumbnailDiv);
            }

            // Campo especial para "fotolugapass"
            if (key === 'FOTO DO JOGO') {
                input.setAttribute('id', 'fotolugapassInput');

                const thumbnailContainer = document.createElement('div');
                thumbnailContainer.className = 'thumbnail-container';

                fotolugapassImages.forEach((imageUrl) => {
                    const thumbnailDiv = document.createElement('div');
                    thumbnailDiv.className = 'thumbnail';
                    thumbnailDiv.title = 'Selecionar esta foto';

                    const thumbnailImg = document.createElement('img');
                    thumbnailImg.src = imageUrl;

                    thumbnailDiv.appendChild(thumbnailImg);
                    thumbnailDiv.onclick = () => {
                        document.querySelectorAll('.thumbnail').forEach(el => el.classList.remove('selected'));
                        thumbnailDiv.classList.add('selected');
                        input.value = imageUrl;
                    };

                    thumbnailContainer.appendChild(thumbnailDiv);
                });

                formGroup.appendChild(thumbnailContainer);
            }

            // Adiciona os campos ao formulário, exceto os ocultos
            if (key !== 'element_active') {
                formGroup.appendChild(label);
                formGroup.appendChild(input);
                form.appendChild(formGroup);
            } else {
                // Adiciona o campo oculto diretamente ao formulário
                form.appendChild(input);
            }
        }
    } catch (error) {
        console.error('Erro ao buscar configuração:', error);
    }
}


        async function saveConfig() {
            const form = document.getElementById('configForm');
            const formData = new FormData(form);
            const updatedConfig = {};

            formData.forEach((value, key) => {
                updatedConfig[key] = value;
            });

            try {
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(updatedConfig),
                });
                const result = await response.json();
                alert(result.message || 'Configuração salva com sucesso!');
            } catch (error) {
                console.error('Erro ao salvar configuração:', error);
                alert('Erro ao salvar configuração.');
            }
        }

        // Carrega os dados ao iniciar
        fetchConfig();
    </script>

<footer style="text-align: center; margin-top: 20px; font-size: 14px; color: #888;">
    Desenvolvido by <strong>LEANDROTN</strong>, CEO Owner from <strong>TNCorporation Brazil</strong>
</footer>
</body>
</html>