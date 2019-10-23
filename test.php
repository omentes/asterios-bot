<?php
require "vendor/autoload.php";
$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();
date_default_timezone_set('Europe/Moscow');
$dbhost = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$dbcharset = getenv('DB_CHARSET');
$dsn = "mysql:host={$dbhost};dbname={$dbname};charset={$dbcharset}";
$usr = getenv('DB_USERNAME');
$pwd = getenv('DB_PASSWORD');

$pdo = new \Slim\PDO\Database($dsn, $usr, $pwd);

$selectStatement = $pdo->select(['title', 'description', 'timestamp'])
    ->from('new_raids')
    ->where('server', '=', '0')
    ->orderBy('created_at', 'desc')
    ->limit(20, 0);

$stmt = $selectStatement->execute();
$data = $stmt->fetchAll();

$url = 'https://asterios.tm/index.php?cmd=rss&serv=0&filter=keyboss&out=xml';
$rss = Feed::loadRss($url);

$newData = $rss->toArray();
$remoteBefore = $newData['item'] ?? [];

$remote = array_map(function ($record) {
    return [
        'title' => $record['title'],
        'description' => $record['description'],
        'timestamp' => $record['timestamp'],
    ];
}, array_slice($remoteBefore, 0, 20));
$local = $data;//array_column($data, 'text');
$newRaids = array_diff_key($remote, $local);
//pp($newRaids);
echo '[log] parse done, diff count ' . count($newRaids) . PHP_EOL;
foreach ($newRaids as $raid) {
    try {
        $insertStatement = $pdo->insert([
            'server',
            'title',
            'description',
            'timestamp'
        ])
            ->into('new_raids')
            ->values([
                0,
                $raid['title'],
                $raid['description'],
                $raid['timestamp'],
            ]);
        $insertId = $insertStatement->execute(false);
//        $channel = isSubclassRb((string)$raid) ? '@asteriosx5rb' : '@asteriosX5keyRB';
//        echo send_msg((string)$raid, $channel) . PHP_EOL;
    } catch (\Throwable $e) {
        $error = $e->getMessage();
        echo "ERROR! $error";
        die();
    }
    $date = new DateTime();
    $date->setTimestamp($raid['timestamp']);

    echo $date->format('Y-m-d H:i:s') . ' ' . $raid['title'] . $raid['description'] .PHP_EOL;
}


function pp($item)
{
    var_export($item);
    die();
}