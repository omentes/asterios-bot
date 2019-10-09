<?php

require "vendor/autoload.php";
use PHPHtmlParser\Dom;

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$dbhost = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$dbcharset = getenv('DB_CHARSET');
$dsn = "mysql:host={$dbhost};dbname={$dbname};charset={$dbcharset}";
$usr = getenv('DB_USERNAME');
$pwd = getenv('DB_PASSWORD');

$pdo = new \Slim\PDO\Database($dsn, $usr, $pwd);

$selectStatement = $pdo->select(['text'])
    ->from('raids')
    ->orderBy('id', 'desc')
    ->limit(10, 0);

$stmt = $selectStatement->execute();
$data = $stmt->fetchAll();

$dom = new Dom;
$dom->loadFromUrl('https://asterios.tm/index.php?cmd=rss&serv=0&filter=keyboss');
$contents = $dom->find('td');

$remote = [];
foreach ($contents as $content) {
	if (stristr($content, 'was killed')) {
        $raids = $content->find('td');
        foreach ($raids as $raid) {
            $currentRaids = $raid->find('a');
            foreach ($currentRaids as $raidTD) {
                $remote[] = $raidTD->text();
            }
        }
        break;
	}
}
$remote = array_slice($remote, 0, 10);
$local = array_column($data, 'text');
$newRaids = array_diff($remote, $local);

foreach ($newRaids as $raid) {
    try {
        $insertStatement = $pdo->insert(['text'])
            ->into('raids')
            ->values([$raid]);
        $insertId = $insertStatement->execute(false);
        echo send_msg((string)$raid) . PHP_EOL;
    } catch (\Throwable $e) {
        $error = $e->getMessage();
        echo "ERROR! $error";
        die();
    }
    echo "$raid";
}

function send_msg($text)
{
    $apiToken = getenv('TG_API');

    $data = [
        'chat_id' => '@asteriosx5rb',
        'text' => $text
    ];

    return file_get_contents("https://api.telegram.org/bot{$apiToken}/sendMessage?" . http_build_query($data) );
}
