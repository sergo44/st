<?php

namespace St;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class PHPMailerHelper
{
    /**
     * Возвращает объект PHPMailer
     * @throws Exception
     */
    public static function getPHPMailer(): PHPMailer
    {
        $mailer = new PHPMailer();

        $mailer->isSMTP();
        $mailer->SMTPAuth = true;
        $mailer->SMTPDebug = 0;
        $mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

        $mailer->Host = sprintf("ssl://%s",ST_SMTP_HOST);
        $mailer->Port = 465;

        $mailer->Username   = ST_SMTP_USER;
        $mailer->Password   = ST_SMTP_PASSWORD;

        $mailer->CharSet = PHPMailer::CHARSET_UTF8;

        $mailer->setFrom('soberi.tur@mail.ru', "Собери Тур");


        $mailer->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );


        return $mailer;
    }
}