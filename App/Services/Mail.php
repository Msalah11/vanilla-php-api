<?php

namespace App\Services;

use App\Core\Application;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mail
{
    private PHPMailer $mailer;
    private $mailSetting;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->mailSetting = Application::get('config')['mail'];

        $this->mailer->isSMTP();
        $this->mailer->SMTPAuth = $this->mailSetting['auth'];
        $this->mailer->Host = $this->mailSetting['host'];
        $this->mailer->Username = $this->mailSetting['username'];
        $this->mailer->Password = $this->mailSetting['password'];
        $this->mailer->Port = $this->mailSetting['port'];
        $this->mailer->setFrom($this->mailSetting['from_address'], $this->mailSetting['from_name']);
        $this->mailer->isHTML(true);
    }

    public function send($email, $password)
    {
        try {
            $this->mailer->addAddress($email, 'MSalah');
            $this->mailer->Subject = 'Your New Password';
            $this->mailer->Body = "Hello User, <p>Your New Password is {$password}</p><br>Thanks";

            if(!$this->mailer->send()){
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $this->mailer->ErrorInfo;
            }

        } catch (Exception $e) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $this->mailer->ErrorInfo;
        }
    }
}