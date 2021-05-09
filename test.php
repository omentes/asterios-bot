<?php

require "vendor/autoload.php";
        $dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
        $dotenv->load();
	date_default_timezone_set('Europe/Moscow');

        $dbhost = getenv('DB_HOST');
        $dbname = getenv('DB_NAME');
        $dbcharset = getenv('DB_CHARSET');
        $dsn = "mysql:host={$dbhost};dbname={$dbname};charset={$dbcharset}";
        $usr = getenv('DB_USERNAME');
        $pwd = getenv('DB_PASSWORD');

	$pdo = new \FaaPz\PDO\Database($dsn, $usr, $pwd);

	$selectStatement = $pdo
		->select(['title', 'description', 'timestamp'])
            ->from('new_raids')
            ->where(
                new \FaaPz\PDO\Clause\Grouping(
                    "AND",
                    new \FaaPz\PDO\Clause\Conditional('server', '=', 0),
                    new \FaaPz\PDO\Clause\Conditional('title', 'LIKE', "%Cabrio%")
                )
            )
	    ->orderBy('timestamp', 'desc');
        $stmt = $selectStatement->execute();

	$raids = $stmt->fetchAll();
	$old = new DateTime();
$results = [];
foreach ($raids as $index => $raid) {
    if ($index) {
        $time = new DateTime();
        $time->setTimestamp($raid['timestamp']);
        $diff = $old->diff($time);
        $hours = $diff->h;
        $hours = $hours + ($diff->days*24);
        $minutes = $diff->i;
        echo "{$hours}:{$minutes}\n";
        if (!isset($results[$hours])) {
            $results[$hours] = 1;
        } else {
            $results[$hours]++;
        }
    }
    $old->setTimestamp($raid['timestamp']);
}

ksort ($results);

foreach ($results as $index => $result) {
    echo "{$index}\t";
    foreach (range(0, $result) as $r) {
        echo "x";
    }
    echo "\n";
}
echo "All: " . count($raids) . "\n";
pp($results);

function pp($item)
{
    echo PHP_EOL;
    echo 'pp' . PHP_EOL;
    var_export($item);
    echo PHP_EOL;
    die();
}


