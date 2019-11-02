<?php


namespace core;


final class Mail {
    /**
     * @var string
     */
    private $to;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $headers = array();

    /**
     * Mail constructor.
     * @param string $to
     * @param string $subject
     * @param string $message
     */
    public function __construct(string $to, string $subject, string $message) {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
    }

    public function from(string $from) {
        $this->header('From', $from);
    }

    public function replyTo(string $replyTo) {
        $this->header('Reply-To', $replyTo);
    }

    private function header(string $header, string $value) {
        $this->headers[$header] = $value;
    }

    /**
     * Sends the mail
     * @throws MailException
     */
    public function send() {
        // Max 70 lines
        //$message = wordwrap($this->message, 70);

        if (!mail($this->to, $this->subject, $message, $this->headers)) {
            throw new MailException('An error occurred sending the mail...');
        }
    }
}