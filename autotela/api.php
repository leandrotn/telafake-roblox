<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: https://www.roblox.com/pt/home');
    exit;
}

// Configurar exibição de erros
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificar se a URL foi passada como parâmetro
if (!isset($_GET['get'])) {
    die("Parâmetro 'get' com a URL é obrigatório.");
}

// URL fornecida
$url = filter_var($_GET['get'], FILTER_VALIDATE_URL);
if (!$url) {
    die("URL inválida.");
}

// Cabeçalhos da requisição
$headers = [
    'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7',
    'accept-language: pt-BR,pt;q=0.9,en;q=0.8,en-GB;q=0.7,en-US;q=0.6',
    'cache-control: max-age=0',
    'priority: u=0, i',
    'sec-ch-ua: "Microsoft Edge";v="131", "Chromium";v="131", "Not_A Brand";v="24"',
    'sec-ch-ua-mobile: ?0',
    'sec-ch-ua-platform: "Windows"',
    'sec-fetch-dest: document',
    'sec-fetch-mode: navigate',
    'sec-fetch-site: none',
    'sec-fetch-user: ?1',
    'upgrade-insecure-requests: 1',
    'user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36 Edg/131.0.0.0',
    'cookie: RBXcb=RBXViralAcquisition=true&RBXSource=true&GoogleAnalytics=true; GuestData=UserID=-840437831; _ga=GA1.1.1625318027.1721873217; .ROBLOSECURITY=SEU_COOKIE_AQUI'
];

// Inicializar cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

// Capturar resultado
$result = curl_exec($ch);
curl_close($ch);

// Carregar HTML usando DOMDocument
$dom = new DOMDocument();
libxml_use_internal_errors(true); // Ignorar erros de parsing
$dom->loadHTML($result);
libxml_clear_errors();

$xpath = new DOMXPath($dom);

// Extração de dados
$title = $dom->getElementsByTagName('h1')->item(0)->textContent ?? '';
$username = $xpath->query("//a[contains(@class, 'text-name')]")->item(0)->textContent ?? '';
$username = ltrim($username, '@'); // Remover o "@" do início do nome
$robux = $xpath->query("//span[contains(@class, 'text-robux-lg')]")->item(0)->textContent ?? '';
$dataElement = $xpath->query("//div[@class='field-content']")->item(0)->textContent ?? '';
$dataFormatada = DateTime::createFromFormat('M. d, Y', trim($dataElement))->format('m/d/Y') ?? '';
$local = $xpath->query("//p[contains(@class, 'preview-text')]//a[contains(@class, 'text-name')]")->item(0)->textContent ?? '';
$fotopass = $xpath->query("//span[contains(@class, 'thumbnail-span')]/img")->item(0)->getAttribute('src') ?? '';
$fotol = $xpath->query("//div[contains(@class, 'asset-thumbnail')]/a/img")->item(0)->getAttribute('src') ?? '';
$description = $xpath->query("//p[@id='item-details-description']")->item(0)->textContent ?? '';
$voteUp = $xpath->query("//span[@id='vote-up-text']")->item(0)->textContent ?? '0';

// Atualizar config.json
$configPath = './sexo/selvagem/eugosto/de/comer/cu/aii/delicia/config.json';

// Verificar se o arquivo existe
if (!file_exists($configPath)) {
    die("Arquivo config.json não encontrado.");
}

// Carregar e decodificar o JSON existente
$config = json_decode(file_get_contents($configPath), true);
if (json_last_error() !== JSON_ERROR_NONE) {
    die("Erro ao decodificar config.json.");
}

// Atualizar os valores
$config['NOME DO PASSE DO DONO'] = $username;
$config['NOME DA PASSE'] = $title;
$config['VALOR ROBUX'] = $robux;
$config['NOME DO JOGO'] = $local;
$config['DATA DO PASSE'] = $dataFormatada;
$config['FOTO DO PASSE'] = $fotopass;

// Verificar descrição
if (!empty(trim($description))) {
    $config['DESCRIÇÃO'] = $description;
    $config['element_active'] = 'Descri&#xE7;&#xE3;o';
} else {
    $config['DESCRIÇÃO'] = '';
    $config['element_active'] = '';
}

$config['LIKE'] = $voteUp;
$config['FOTO DO JOGO'] = $fotol;

// Salvar o arquivo JSON atualizado com UNESCAPED_UNICODE
if (file_put_contents($configPath, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)) === false) {
    die("Erro ao salvar config.json.");
}

echo "Configuração atualizada com sucesso!";
?>
