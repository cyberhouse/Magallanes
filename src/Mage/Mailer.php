<?php
namespace Mage;

/*
 * (c) 2011-2015 Andrés Montañez <andres@andresmontanez.com>
 * (c) 2016 by Cyberhouse GmbH <office@cyberhouse.at>
 *
 * This is free software; you can redistribute it and/or
 * modify it under the terms of the MIT License (MIT)
 *
 * For the full copyright and license information see
 * <https://opensource.org/licenses/MIT>
 */

class Mailer
{
    const EOL     = "\r\n";
    const SUBJECT = '[Magallanes] Deployment of {project} to {environment}: {result}';

    protected $address;
    protected $project;
    protected $environment;
    protected $logFile;

    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    public function setProject($project)
    {
        $this->project = $project;
        return $this;
    }

    public function setEnvironment($environment)
    {
        $this->environment = $environment;
        return $this;
    }

    public function setLogFile($logFile)
    {
        $this->logFile = $logFile;
        return $this;
    }

    public function send($result)
    {
        $boundary = md5(date('r', time()));

        $headers = 'From: ' . $this->address
            . self::EOL
            . 'Reply-To: ' . $this->address
            . self::EOL
            . 'MIME-Version: 1.0'
            . self::EOL
            . 'Content-Type: multipart/mixed; boundary=Mage-mixed-' . $boundary;

        $subject = str_replace(
            ['{project}', '{environment}', '{result}'],
            [$this->project, $this->environment, $result ? 'SUCCESS' : 'FAILURE'],
            self::SUBJECT
        );
        $attachment = chunk_split(base64_encode(file_get_contents($this->logFile)));

        $message = 'This is a multi-part message in MIME format.' . self::EOL
            . '--Mage-mixed-' . $boundary . self::EOL
            . 'Content-Type: text/plain; charset=iso-8859-1' . self::EOL
            . 'Content-Transfer-Encoding: quoted-printable' . self::EOL
            . self::EOL
            . strip_tags(Console::getOutput()) . self::EOL
            . self::EOL
            . '--Mage-mixed-' . $boundary . self::EOL
            . 'Content-Type: text/plain; name="log.txt"' . self::EOL
            . 'Content-Transfer-Encoding: base64' . self::EOL
            . 'Content-Disposition: attachment' . self::EOL
            . self::EOL
            . $attachment . self::EOL
            . '--Mage-mixed-' . $boundary . '--' . self::EOL;

        mail($this->address, $subject, $message, $headers);
    }
}
