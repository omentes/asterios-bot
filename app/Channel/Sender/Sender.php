<?php

declare(strict_types=1);

namespace AsteriosBot\Channel\Sender;

use AsteriosBot\Core\App;
use AsteriosBot\Core\Connection\Log;
use AsteriosBot\Core\Connection\Repository;
use AsteriosBot\Core\Exception\EnvironmentException;
use AsteriosBot\Core\Support\Config;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Monolog\Logger;

abstract class Sender
{
    /**
     * @var string
     */
    protected $apiToken;

    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var Client
     */
    private $client;

    /**
     * @var Config
     */
    private $config;

    /**
     * Sender constructor.
     *
     * @param string               $apiToken
     * @param Repository|null      $repository
     * @param Logger|null          $logger
     * @param ClientInterface|null $client
     * @param Config|null          $config
     *
     * @throws EnvironmentException
     */
    public function __construct(
        string $apiToken = '',
        Repository $repository = null,
        Logger $logger = null,
        ClientInterface $client = null,
        Config $config = null
    ) {
        $this->repository = !is_null($repository) ? $repository : Repository::getInstance();
        $this->logger = !is_null($logger) ? $logger : Log::getInstance()->getLogger();
        $this->client = !is_null($client) ? $client : new Client();
        $this->config = !is_null($config) ? $config : App::getInstance()->getConfig();
        $this->apiToken = !empty($apiToken) ? $apiToken : $this->config->getTelegramToken();
    }

    /**
     *
     * @param string $text
     * @param string $channel
     *
     * @return string
     */
    public function sendMessage(string $text, string $channel): string
    {
        if ($this->config->isSilentMode()) {
            return 'silent mode on';
        }
        $data = [
            'chat_id' => $channel,
            'text' => $text
        ];

        try {
            $url = "https://api.telegram.org/bot{$this->apiToken}/sendMessage?" . http_build_query($data) . "&parse_mode=html";
            $response = $this->client->get($url);
            $result = $response->getBody()->getContents();
        } catch (\Exception $e) {
            $result = $e->getMessage();
        }

        return $result;
    }
}
