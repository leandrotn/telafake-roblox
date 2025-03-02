<?php
session_start();

// Configurar o encoding para UTF-8
header('Content-Type: application/json; charset=utf-8');
mb_internal_encoding('UTF-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se o usuário está logado
    if (!isset($_SESSION['username'])) {
        http_response_code(401); // Não autorizado
        echo json_encode(['message' => 'Acesso não autorizado.']);
        exit;
    }

    // Lê os dados recebidos no corpo da requisição
    $input = json_decode(file_get_contents('php://input'), true, 512, JSON_UNESCAPED_UNICODE);

    if (!isset($input['adminNome']) || !isset($input['adminFoto'])) {
        http_response_code(400); // Requisição malformada
        echo json_encode(['message' => 'Dados incompletos.']);
        exit;
    }

    // Carrega a configuração existente (simulação de arquivo JSON)
    $configFile = './sexo/selvagem/eugosto/de/comer/cu/aii/delicia/config.json';
    $config = file_exists($configFile) ? json_decode(file_get_contents($configFile), true, 512, JSON_UNESCAPED_UNICODE) : [];

    // Atualiza apenas os campos "ADMINISTRADOR" e "ADMIN FOTO"
    $config['ADMINISTRADOR'] = $input['adminNome'];
    $config['ADMIN FOTO'] = $input['adminFoto'];

    // Salva novamente o arquivo de configuração com suporte a UTF-8
    if (file_put_contents($configFile, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))) {
        echo json_encode(['message' => 'Configuração salva com sucesso.']);
    } else {
        http_response_code(500); // Erro interno do servidor
        echo json_encode(['message' => 'Erro ao salvar configuração.']);
    }
} else {
    http_response_code(405); // Método não permitido
    echo json_encode(['message' => 'Método não permitido.']);
}
?>