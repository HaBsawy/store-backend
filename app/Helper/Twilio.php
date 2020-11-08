<?php


namespace App\Helper;


use Twilio\Rest\Client;

class Twilio
{
    public static function send($to, $body)
    {
        $twilio = new Client(env('TWILIO_AUTH_SID'), env('TWILIO_AUTH_TOKEN'));

        $twilio->messages->create("whatsapp:+2" . $to, [
            "from" => "whatsapp:+14155238886",
            "body" => $body
        ]);
    }
}
