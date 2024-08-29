<?php

namespace Boshnik\Quiz;

use Boshnik\Quiz\Traits\Helps;

class Form
{
    use Helps;
    public string $classkey = \QuizSave::class;

    function __construct(
        public \modX $modx,
        public array $request = []
    ) {}

    /**
     * @param $email
     * @param $subject
     * @param $message
     * @param $files
     * @return mixed
     */
    public function sendEmail($email, $subject, $message, $files): mixed
    {
        /* load mail service */
        $this->modx->getService('mail', 'mail.modPHPMailer');

        /* set HTML */
        $this->modx->mail->setHTML(true);

        /* set email main properties */
        $this->modx->mail->set(\modMail::MAIL_BODY, $message);
        $this->modx->mail->set(\modMail::MAIL_FROM, $this->modx->getOption('emailsender'));
        $this->modx->mail->set(\modMail::MAIL_FROM_NAME, $this->modx->getOption('site_name'));
        $this->modx->mail->set(\modMail::MAIL_SUBJECT, $subject);

        foreach ($files as $file) {
            if ($file['error'] == UPLOAD_ERR_OK) {
                $this->modx->mail->mailer->addAttachment($file['tmp_name'], $file['name']);
            }
        }

        $this->modx->mail->address('to', $email);

        $sent = $this->modx->mail->send();

        $this->modx->mail->reset([
            \modMail::MAIL_CHARSET => $this->modx->getOption('mail_charset', null, 'UTF-8'),
            \modMail::MAIL_ENCODING => $this->modx->getOption('mail_encoding', null, '8bit'),
        ]);

        if (!$sent) {
            $this->modx->log(1, '[Form] '. print_r($this->modx->mail->mailer->ErrorInfo, true));
        }

        return $sent;
    }


}