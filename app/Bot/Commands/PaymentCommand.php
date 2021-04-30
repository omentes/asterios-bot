<?php

declare(strict_types=1);

namespace Longman\TelegramBot\Commands\SystemCommand;

use AsteriosBot\Core\Connection\Cache;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\Payments\LabeledPrice;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

/**
 * Donate command
 *
 * Gets executed when a user first starts using the bot.
 */
class PaymentCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'payment';
    /**
     * @var string
     */
    protected $description = 'Payment command';
    /**
     * @var string
     */
    protected $usage = '/Payment';
    /**
     * @var string
     */
    protected $version = '1.0.0';
    /**
     * @var bool
     */
    protected $private_only = true;


    /**
     * Main command execution
     *
     * @return ServerResponse
     */
    public function execute(): ServerResponse
    {
        $chat_id = $this->getMessage()->getFrom()->getId();
        $currency = 'EUR';
        $cache = Cache::getInstance()->getConnection();
        $price = $cache->get($chat_id . '_arb_donate');
        $cache->del($chat_id . '_arb_donate');
        $prices = [
            new LabeledPrice(['label' => 'Задонатить Asterios RB Bot', 'amount' => (int) $price]),
        ];
        $need_shipping_address = false;
        $is_flexible = false;

        return Request::sendInvoice([
            'chat_id'               => $chat_id,
            'title'                 => 'Donate Asterios RB Bot',
            'description'           => 'Donate Asterios RB Bot',
            'payload'               => 'payment',
            'start_parameter'       => 'payment',
            'provider_token'        => $this->getConfig('payment_provider_token'),
            'currency'              => $currency,
            'prices'                => $prices,
            'need_shipping_address' => $need_shipping_address,
            'is_flexible'           => $is_flexible,
        ]);
    }
}
