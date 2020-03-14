<?php
require "vendor/autoload.php";

class AsteriosBotManager
{
    public const X5 = 0;
    public const X7 = 8;
    public const URL_X5 = 'https://asterios.tm/index.php?cmd=rss&serv=0&filter=keyboss&out=xml';
    public const URL_X7 = 'https://asterios.tm/index.php?cmd=rss&serv=8&filter=keyboss&out=xml';
    public const CHANNELS = [
        self::X5 => [
            'sub' => '@asteriosx5rb',
            'key' => '@asteriosX5keyRB',
            ],
        self::X7 => [
            'sub' => '@asteriosx7rb',
            'key' => '@asteriosX7keyRB',
            ],
    ];
    public function __construct()
    {
        $dotenv = Dotenv\Dotenv::create(__DIR__);
        $dotenv->load();
        date_default_timezone_set('Europe/Moscow');
    }

    public function getPDO()
    {
        $dbhost = getenv('DB_HOST');
        $dbname = getenv('DB_NAME');
        $dbcharset = getenv('DB_CHARSET');
        $dsn = "mysql:host={$dbhost};dbname={$dbname};charset={$dbcharset}";
        $usr = getenv('DB_USERNAME');
        $pwd = getenv('DB_PASSWORD');

        return new \Slim\PDO\Database($dsn, $usr, $pwd);
    }

    public function getDataPDO(\Slim\PDO\Database $pdo, int $server, int $limit = 20)
    {
        $selectStatement = $pdo->select(['title', 'description', 'timestamp'])
            ->from('new_raids')
            ->where('server', '=', $server)
            ->orderBy('timestamp', 'desc')
            ->limit($limit, 0);

        $stmt = $selectStatement->execute();
        return $stmt->fetchAll();
    }

    public function getDataPDOid(\Slim\PDO\Database $pdo, int $server, int $limit = 20)
    {
        $selectStatement = $pdo->select(['id', 'title', 'description', 'timestamp'])
            ->from('new_raids')
            ->where('server', '=', $server)
            ->orderBy('timestamp', 'desc')
            ->limit($limit, 0);

        $stmt = $selectStatement->execute();
        return $stmt->fetchAll();
    }


    public function getRSSData(string $url, int $limit = 20)
    {
        $rss = Feed::loadRss($url);

        $newData = $rss->toArray();
        $remoteBefore = $newData['item'] ?? [];

        return array_map(function ($record) {
            return [
                'title' => $record['title'],
                'description' => $record['description'],
                'timestamp' => $record['timestamp'],
            ];
        }, array_slice($remoteBefore, 0, $limit));
    }

    public function trySend(\Slim\PDO\Database $pdo, array $raid, int $server)
    {
        $date = new DateTime();
        $date->setTimestamp($raid['timestamp']);
        try {
            $insertStatement = $pdo->insert([
                'server',
                'title',
                'description',
                'timestamp'
            ])
                ->into('new_raids')
                ->values([
                    $server,
                    $raid['title'],
                    $raid['description'],
                    $raid['timestamp'],
                ]);
            $insertId = $insertStatement->execute(false);
            $channel = $this->getChannel($raid, $server);
	    $text = $date->format('Y-m-d H:i:s') . ' ' . $raid['description'];

        $timeUp = new DateTime();
        $timeUp->setTimestamp($raid['timestamp'] + 18*60*60);
        $timeDown = new DateTime();
        $timeDown->setTimestamp($raid['timestamp'] + 30*60*60);

        if ($this->isSubclassRb($raid['title'])) {
            $text .= "\n\nВремя респа: C " . $timeUp->format('Y-m-d H:i:s') . ' до ' . $timeDown->format('Y-m-d H:i:s');
            if (0 === $server) {
                $text .= "\n\nДонат:\nВариант 1: купить пушку и кри для Реорина => Oren, <code>target /BarbaraLiskov</code>\nВариант 2: Купить голду на сайте или отправить почтой на персонажа AmazonS3 (x5 сервер)";
            };
            if (8 === $server) {
                $text .= "\n\nДонат:\nКупить голду на сайте или отправить почтой на персонажа AmazonS3 (x5 сервер)";
            };
            $text .= "\n\nТоповый донат - 6 голды от пользователя pepega228";
        }



        echo $this->send_msg($text, $channel) . PHP_EOL;
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            echo "ERROR! $error";
            die();
        }
    }

    public function send_msg($text, $channel)
    {
        $apiToken = getenv('TG_API');

        $data = [
            'chat_id' => $channel,
            'text' => $text
        ];
        try {
            $handle = curl_init();

            $url = "https://api.telegram.org/bot{$apiToken}/sendMessage?" . http_build_query($data) . "&parse_mode=html";
            curl_setopt($handle, CURLOPT_URL, $url);
// Set the result output to be a string.
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

            $output = curl_exec($handle);

            curl_close($handle);

            $result =  $output;

//             = file_get_contents($url);
        }
        catch (\Exception $e) {
            $result = $e->getMessage();
        }

        return $result;
    }

    public function isSubclassRb(string $text)
    {
        return $this->contains($text, [
            'Cabrio',
            'Hallate',
            'Kernon',
            'Golkonda',
        ]);
    }

    public function contains($str, array $raids)
    {
        foreach ($raids as $raid) {
            if (stripos($str, $raid) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param array $raid
     * @return string
     */
    public function getChannel(array $raid, int $server): string
    {
        return $this->isSubclassRb($raid['title']) ? self::CHANNELS[$server]['sub'] : self::CHANNELS[$server]['key'];
    }

    /**
     * @param array $raids
     * @return array
     */
    public function getDeadRB(array $raids)
    {
        $result = [];
        $raids = array_reverse($raids);
	
	foreach ($raids as $raid) {
		$fix = 60*60*21; //97200 is 27 hours
	//	if ($this->isSubclassRb($raid['title'])) {
			$raid['timestamp'] = time() - $raid['timestamp'] - 18*60*60 ;//- $fix;// $fix;
			$raid['name'] = explode(' was', $raid['title'])[0] ?? '';
			$result[md5($raid['title'])] = $raid;
			
	   // }
	}

	return $result;
    }

    public function checkRespawnTime(int $time)
    {
	if ($time >= 32400 && $time < 37800) {
            return 1;
	} elseif ($time >= 37800) {
	return 2;
	}
	return 0;
    }

    public function alarm(\Slim\PDO\Database $pdo, array $record, int $mode)
    {
	 $selectStatement = $pdo->select(['id', 'title', 'server', 'alarm'])
            ->from('new_raids')
            ->where('id', '=', $record['id']);
        $stmt = $selectStatement->execute();
        $result = $stmt->fetchAll();
	$recordMode = $result[0]['alarm'] ?? 0;
	if ($recordMode === $mode || !$this->isSubclassRb($record['name'])) {
	    return $result;
	}
	if ($mode === 1 && $recordMode === 0) {
	
            $msg = 'ALARM! Осталось менее 3ч респауна ' . $record['name'];  
	}
	if ($mode === 2 && $recordMode === 1) {
	
            $msg = 'ALARM! Осталось менее 1,5ч респауна ' . $record['name'];  
	}
	$this->update($pdo, $mode, $record['id']);
	$channel = $this->getChannel($result[0], $result[0]['server']);
	echo $this->send_msg($msg, $channel) . PHP_EOL;


    }

    public function update(\Slim\PDO\Database $pdo, $mode, $id)
    {
        $updateStatement = $pdo->update(['alarm' => $mode])
                 ->table('new_raids')
                 ->where('id', '=', $id);
	$affectedRows = $updateStatement->execute();
    }
}
