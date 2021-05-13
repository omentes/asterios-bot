<?php

declare(strict_types=1);

namespace AsteriosBot\Bot;

use AsteriosBot\Core\Connection\Repository;
use AsteriosBot\Core\Support\Config;
use DateTime;

class AnswerHandler
{
    /**
     * @var AnswerDTO
     */
    private AnswerDTO $dto;

    /**
     * @var Repository
     */
    private Repository $repository;

    public function __construct(AnswerDTO $dto, Repository $repository = null)
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
        if ($this->dto->getType() === 'servers') {
            return "Выберете сервер";
        }
        if ($this->dto->getType() !== 'all') {
            $raid = $this->repository->getLastRaidLikeName($this->dto->getType(), $this->dto->getServerId());
            return $this->prepareText(
                $raid,
                $this->dto->getType(),
                BotHelper::getFloor($this->dto->getType()),
                $this->dto->getServerName()
            );
        }
        $result = '';
        $names = BotHelper::RAID_NAMES;
        foreach ($names as $name) {
            $raid = $this->repository->getLastRaidLikeName($name, $this->dto->getServerId());
            $result .= $this->prepareText(
                $raid,
                $name,
                BotHelper::getFloor($name),
                $this->dto->getServerName()
            );
        }
        $result .= "\nУчить английские слова @RepeatWordBot\n\nДонат:\n";
        $result .= "- вкачать твина по рефералке на х5 https://bit.ly/asterios-invites ";
        $result .= "или на х7 http://bit.ly/x7-11-gold\n- /donate - купить админу бота кофе или оплатить сервер для бота";
        return $result;
    }
    
    /**
     * @param bool $dark
     *
     * @return string
     */
    public function getSvg(bool $dark = false): string
    {
        $result = [];
        $names = BotHelper::RAID_NAMES;
        foreach ($names as $name) {
            $raid = $this->repository->getLastRaidLikeName($name, $this->dto->getServerId());
            $result = array_merge($result, BotHelper::prepareTextForExport(
                $raid,
                $name,
                BotHelper::getFloor($name)
            ));
        }
        return $this->getSvgContent($result, $dark);
    }

    /**
     * @param array  $raid
     * @param string $name
     * @param int    $floor
     * @param string $serverName
     *
     * @return string
     */
    private function prepareText(array $raid, string $name, int $floor, string $serverName): string
    {
        $raid['timestamp'] = intval($raid['timestamp']);
        if (empty($raid)) {
            return 'Что-то пошло не так...';
        }
        $floors = $floor > 0 ? " ({$floor} этаж)" : '';
        $server = "\[$serverName]";
        if (time() - $raid['timestamp'] < Config::EIGHTEEN_HOURS) {
            $respawn = new DateTime();
            $respawn->setTimestamp(Config::EIGHTEEN_HOURS + $raid['timestamp']);
            $now = new DateTime();
            $now->setTimestamp(time());
            $interval = $respawn->diff($now);
            return "{$server} {$name}{$floors}: респ начнется через " . $interval->format('%H:%I:%S') . "\n";
        }
        if (time() - $raid['timestamp'] > Config::THIRTY_HOURS) {
            return "{$server} {$name}{$floors}: уже должен стоять\n";
        }

        $respawn = new DateTime();
        $respawn->setTimestamp($raid['timestamp'] + Config::EIGHTEEN_HOURS);
        $now = new DateTime();
        $now->setTimestamp(time());
        $interval = $now->diff($respawn);
        return "{$server} {$name}{$floors}: респ идет уже " . $interval->format('%H:%I:%S') . "\n";
    }

    /**
     * @param array $result
     * @param bool  $dark
     *
     * @return string
     */
    private function getSvgContent(array $result, bool $dark = false): string
    {
        if (false === $dark) {
            $svg = BotHelper::getWhiteSVGStart();
        } else {
            $svg = BotHelper::getDarkSVGStart();
        }
        foreach ($result as $raid => $info) {
            $svg .= strtr(BotHelper::getSVGContent(), [
                ':raid' => $raid,
                ':resp' => $info,
            ]);
        }
        $svg .= BotHelper::getSVGEnd();

        return strtr($svg, [
            ':server' => $this->dto->getServerName(),
            ':datetime' => date("Y-m-d H:i:s"),
        ]);
    }

    public function getHtml(): string
    {
        $result = [];
        $names = BotHelper::RAID_NAMES;
        foreach ($names as $name) {
            $raid = $this->repository->getLastRaidLikeName($name, $this->dto->getServerId());
            $result = array_merge($result, BotHelper::prepareTextForExport(
                $raid,
                $name,
                BotHelper::getFloor($name)
            ));
        }

        $html = BotHelper::getHtmlStart();
        foreach ($result as $raid => $info) {
            $html .= strtr(BotHelper::getHtmlContent(), [
                ':raid' => $raid,
                ':resp' => $info,
            ]);
        }
        $html .= BotHelper::getHtmlEnd();

        return strtr($html, [
            ':server' => $this->dto->getServerName(),
            ':datetime' => date("Y-m-d H:i:s"),
        ]);
    }
}
