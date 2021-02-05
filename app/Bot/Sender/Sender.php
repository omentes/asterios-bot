<?php
declare(strict_types = 1);

namespace AsteriosBot\Bot\Sender;

class Sender
{
    /**
     *
     * @param string $text
     * @param string $channel
     *
     * @return string
     */
    public function sendMessage(string $text, string $channel): string
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
            $result = curl_exec($handle);
            curl_close($handle);
        }
        catch (\Exception $e) {
            $result = $e->getMessage();
        }
        
        return $result;
    }
}
