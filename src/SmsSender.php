<?php

namespace mssmspackage;

class SmsSender
{
    private $user;
    private $password;
    private $senderid;

    public function __construct($user, $password, $senderid)
    {
        $this->user = $user;
        $this->password = $password;
        $this->senderid = $senderid;
    }

    public function sendSMS($message, $recipients)
    {
        $url = "https://smsvas.com/bulk/public/index.php/api/v1/sendsms";
        $data = [
            "user" => $this->user,
            "password" => $this->password,
            "senderid" => $this->senderid,
            "sms" => $message,
            "mobiles" => $recipients
        ];

        $options = [
            'http' => [
                'header'  => "Content-Type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
            ],
        ];
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) { 
            return "Error sending SMS.";
        }
        return $result;
    }
}
