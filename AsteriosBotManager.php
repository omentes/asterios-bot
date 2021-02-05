<?php
require "vendor/autoload.php";

class AsteriosBotManager
{
    public const X5 = 0;
    public const X3 = 6;
    public const X7 = 8;
    public const URL_X5 = 'https://asterios.tm/index.php?cmd=rss&serv=0&filter=keyboss&out=xml';
    public const URL_X3 = 'https://asterios.tm/index.php?cmd=rss&serv=6&filter=keyboss&out=xml';
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
        self::X3 => [
            'sub' => '@asteriosx3rb',
            'key' => '@asteriosX3keyRB',
            ],
    ];
    public function __construct()
    {
        $dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
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

    public function getRaidsLikeThis(\Slim\PDO\Database $pdo, string $like, int $server, string $order = 'asc')
    {
        $selectStatement = $pdo->select(['*'])
            ->from('new_raids')
            ->where('server', '=', $server)
            ->whereLike('title', "%{$like}%")
            ->orderBy('timestamp', $order);

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
        try {
            $rss = Feed::loadRss($url);
            $newData = $rss->toArray();
        } catch (FeedException $e) {
            $newData = [];
        }
    
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
            $timeDown = new DateTime();
            if ($this->isAllianceRB($raid['title'])) {
                $timeUp->setTimestamp($raid['timestamp'] + 24*60*60);
                $timeDown->setTimestamp($raid['timestamp'] + 48*60*60);
            } else {
                $timeUp->setTimestamp($raid['timestamp'] + 18*60*60);
                $timeDown->setTimestamp($raid['timestamp'] + 30*60*60);
            }
            $rightNow = new DateTime();
            $rightNow->setTimestamp(time());
            $text .= "\n\nВремя респа: C " . $timeUp->format('Y-m-d H:i:s') . ' до ' . $timeDown->format('Y-m-d H:i:s');
            $text .= "\n\nДонат:\n вкачать твина по рефералке на х5 https://bit.ly/asterios-invite-link";
            $text .= "\n\nТоповый донат - 11 голды от пользователя Depsik";
            $text .= "\n\nВремя получения инфы о смерти с сайта Астериоса и публикации этого сообщения: " . $rightNow->format('Y-m-d H:i:s');
    
            echo $this->send_msg($text, $channel) . PHP_EOL;
        } catch (\Throwable $e) {
            $error = $e->getMessage();
            echo "ERROR! $error" . PHP_EOL;
//            die();
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

    public function isAllianceRB(string $text)
    {
        return $this->contains($text, [
            'Ketra',
            'Varka',
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
        $fix = 18 * 60 * 60;
        if (!$this->isSubclassRb($raid['title'])) {
            $fix = 24 * 60 * 60;
        }
        $raid['timestamp'] = time() - $raid['timestamp'] - $fix;
        $raid['name'] = explode(' was', $raid['title'])[0] ?? '';
        $result[md5($raid['title'])] = $raid;
    }

	return $result;
    }

    public function checkRespawnTime(int $time, string $name)
    {
        $threeHours = 32400;
        $oneAndHalfHour = 37800;
        if ($this->isAllianceRB($name)) {
            $threeHours = 75600;
            $oneAndHalfHour = 81000;
        }
        if ($time >= $threeHours && $time < $oneAndHalfHour) {
            return 1;
        } elseif ($time >= $oneAndHalfHour) {
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
        if ($recordMode === $mode) {
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
        echo "===split===\n" . $this->send_msg($msg, $channel) . PHP_EOL . "===split===\n" ;
    }

    public function update(\Slim\PDO\Database $pdo, $mode, $id)
    {
        $updateStatement = $pdo->update(['alarm' => $mode])
                 ->table('new_raids')
                 ->where('id', '=', $id);
	    $affectedRows = $updateStatement->execute();
    }
}
