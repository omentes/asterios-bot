<?php

declare(strict_types=1);

namespace AsteriosBot\Bot\Sender;

use AsteriosBot\Core\Connection\Log;
use AsteriosBot\Core\Connection\Repository;
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
     * Sender constructor.
     *
     * @param string          $apiToken
     * @param Repository|null $repository
     * @param Logger|null     $logger
     */
    public function __construct(
        string $apiToken = '',
        Repository $repository = null,
        Logger $logger = null
    ) {
        $this->apiToken = !empty($apiToken) ? $apiToken : getenv('TG_API');
        $this->repository = !is_null($repository) ? $repository : Repository::getInstance();
        $this->logger = !is_null($logger) ? $logger : Log::getInstance()->getLogger();
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
            $handle = curl_init();
            $url = "https://api.telegram.org/bot{$this->apiToken}/sendMessage?" . http_build_query($data) . "&parse_mode=html";
            curl_setopt($handle, CURLOPT_URL, $url);
            // Set the result output to be a string.
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($handle);
            curl_close($handle);
        } catch (\Exception $e) {
            $result = $e->getMessage();
        }

        return $result;
    }
}
