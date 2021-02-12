<?php

declare(strict_types=1);

namespace AsteriosBot\Bot;

use AsteriosBot\Core\Connection\Repository;
use AsteriosBot\Core\Support\Config;
use DateTime;

class ResponseTextHandler
{
    /**
     * @var Director
     */
    private Director $dto;

    /**
     * @var Repository
     */
    private Repository $repository;

    public function __construct(Director $dto, Repository $repository = null)
    {
        $this->dto = $dto;
        $this->repository = !is_null($repository) ? $repository : Repository::getInstance();
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getText(): string
    {
        if ($this->dto->getRaidBossName() === 'servers') {
            return "Выберете сервер";
        }
        if ($this->dto->getRaidBossName() !== 'all') {
            $raid = $this->repository->getLastRaidLikeName($this->dto->getRaidBossName(), $this->dto->getServerId());
            return $this->prepareText($raid, $this->dto->getRaidBossName());
        }
        $result = '';
        $names = BotHelper::ALL_RAIDS;
        foreach ($names as $name) {
            $raid = $this->repository->getLastRaidLikeName($name, $this->dto->getServerId());
            $result .= $this->prepareText($raid, $name);
        }
        return $result;
    }

    /**
     * @param array  $raid
     * @param string $name
     *
     * @return string
     * @throws \Exception
     */
    private function prepareText(array $raid, string $name): string
    {
        $raid['timestamp'] = intval($raid['timestamp']);
        if (empty($raid)) {
            throw new \Exception('2');
        }
        if (time() - $raid['timestamp'] < Config::EIGHTEEN_HOURS) {
            $respawn = new DateTime();
            $respawn->setTimestamp(Config::EIGHTEEN_HOURS + $raid['timestamp']);
            $now = new DateTime();
            $now->setTimestamp(time());
            $interval = $respawn->diff($now);
            return "{$name}: респ начнется через " . $interval->format('%H:%I:%S') . "\n";
        }
        if (time() - $raid['timestamp'] > Config::THIRTY_HOURS) {
            return "{$name}: уже должен стоять\n";
        }

        $respawn = new DateTime();
        $respawn->setTimestamp($raid['timestamp'] + Config::EIGHTEEN_HOURS);
        $now = new DateTime();
        $now->setTimestamp(time());
        $interval = $now->diff($respawn);
        return "{$name}: респ идет уже " . $interval->format('%H:%I:%S') . "\n";
    }
}
