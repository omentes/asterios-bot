<?php

declare(strict_types=1);

namespace AsteriosBot\Bot\Sender;

use AsteriosBot\Core\Connection\Log;
use AsteriosBot\Core\Connection\Repository;
use GuzzleHttp\Client;
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
     * Sender constructor.
     *
     * @param string          $apiToken
     * @param Repository|null $repository
     * @param Logger|null     $logger
     * @param Client|null     $client
     */
    public function __construct(
        string $apiToken = '',
        Repository $repository = null,
        Logger $logger = null,
        Client $client = null
    ) {
        $this->apiToken = !empty($apiToken) ? $apiToken : getenv('TG_API');
        $this->repository = !is_null($repository) ? $repository : Repository::getInstance();
        $this->logger = !is_null($logger) ? $logger : Log::getInstance()->getLogger();
        $this->client = !is_null($client) ? $client : new Client();
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
