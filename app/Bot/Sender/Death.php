<?php
declare(strict_types = 1);

namespace AsteriosBot\Bot\Sender;

use AsteriosBot\Core\Connection\Repository;
use DateTime;

class Death extends Sender
{
    public function deathMessage(array $raid, int $server)
    {
        $repo = Repository::getInstance();
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
                $timeUp->setTimestamp($raid['timestamp'] + 24 * 60 * 60);
                $timeDown->setTimestamp($raid['timestamp'] + 48 * 60 * 60);
            } else {
                $timeUp->setTimestamp($raid['timestamp'] + 18 * 60 * 60);
                $timeDown->setTimestamp($raid['timestamp'] + 30 * 60 * 60);
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
}
