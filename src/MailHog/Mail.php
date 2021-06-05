<?php

declare(strict_types=1);

namespace R3H6\Typo3Testing\MailHog;

class Mail
{
    /**
     * @var array
     */
    protected $maiLData = [];

    /**
     * @var array
     */
    protected $recipients;

    /**
     * @var string
     */
    protected $sender;

    /**
     * @var string
     */
    protected $subject;

    /**
     * @var string
     */
    protected $body;

    /**
     * Mail constructor.
     * @param array $mailData
     */
    public function __construct(array $mailData)
    {
        $this->maiLData = $mailData;

        $this->body = utf8_encode(quoted_printable_decode($this->maiLData['Content']['Body']));
        $this->recipients = $this->getHeader('To');
        $this->subject = implode(', ', $this->getHeader('Subject'));
        $this->sender = implode(',', $this->getHeader('From'));
    }

    public function getHeader(string $header): array
    {
        $header = $this->maiLData['Content']['Headers'][$header];
        return array_map(new ImapDecoder(), $header);
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getRecipients(): array
    {
        return $this->recipients;
    }

    public function getSender(): string
    {
        return $this->sender;
    }
}
