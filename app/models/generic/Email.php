<?php

declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . "/../../../app/middleware/phpmailer/PHPMailer-master/src/Exception.php";
require_once __DIR__ . "/../../../app/middleware/phpmailer/PHPMailer-master/src/PHPMailer.php";
require_once __DIR__ . "/../../../app/middleware/phpmailer/PHPMailer-master/src/SMTP.php";

class Email
{

  private Config $config;

  public function __construct(Config $config)
  {
    $this->config = $config;
  }

  public function Email(
    bool $errorMode,
    int $debugMode,
    array $sentFrom,
    array $sendTo,
    array $replyTo,
    string $emailSubject,
    string $emailBody,
    string $emailAltBody,
    array $attachments,
    array $images
  ) : string
  {
    $host = $this->config->GetEmailHost();
    $username = $this->config->GetEmailUsername();
    $password = $this->config->GetEmailPassword();

    $mail = new PHPMailer(true);
    try
    {
      date_default_timezone_set('Etc/UTC');

      $mail->isSMTP();

      $mail->SMTPOptions = array(
        'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
        )
      );

      $mail->CharSet = 'UTF-8';
      $mail->SMTPDebug = $debugMode;
      $mail->Mailer = "smtp";
      $mail->Host = $host;
      $mail->SMTPAuth = true;
      $mail->AuthType = "login";
      $mail->Priority = 1;
      $mail->Username = $username;
      $mail->Password = $password;
      $mail->SMTPSecure = "ssl";
      $mail->Port = 465;
      $mail->SMTPKeepAlive = true;

      $mail->setFrom($sentFrom[0], $sentFrom[1]);

      $count = count($replyTo);
      if($count > 0)
      {
        $mail->addReplyTo($replyTo[0], $replyTo[0]);
      }

      $count = count($sendTo);
      if($count > 0)
      {
        for($i = 0; $i < $count; $i++)
        {
          $mail->addAddress($sendTo[$i][0], $sendTo[$i][1]);
        }
      }

      $count = count($attachments);
      if($count > 0)
      {
        for($i = 0; $i < $count; $i++)
        {
          $mail->addAttachment($attachments[$i][0], $attachments[$i][1]);
        }
      }

      $count = count($images);
      if($count > 0)
      {
        for($i = 0; $i < $count; $i++)
        {
          $mail->addAttachment($images[$i][0], $images[$i][1]);
        }
      }

      $mail->isHTML(true);
      $mail->Subject = $emailSubject;
      $mail->Body    = $emailBody;
      $mail->AltBody = $emailAltBody;

      try
      {
        $mail->send();
        return "SENT";
      }
      catch(Exception $e)
      {
        return "ERROR SENDING MAIL";
      }

      $mail->smtpClose();
    }
    catch (Exception $e)
    {
      if($errorMode === true)
      {
        return 'Mailer Error: ' . $mail->ErrorInfo;
      }
      else
      {
        return "FAIL";
      }
    }
  }
}