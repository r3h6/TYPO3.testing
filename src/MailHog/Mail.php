<?php

namespace R3H6\Typo3Testing\MailHog;

use TYPO3\CMS\Core\Utility\ArrayUtility;

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

        $this->body = utf8_encode(quoted_printable_decode(ArrayUtility::getValueByPath($this->maiLData, 'Content/Body')));
        $this->recipients = $this->getHeader('To');
        $this->subject = implode(', ', $this->getHeader('Subject'));
        $this->sender = implode(',', $this->getHeader('From'));
    }

    /**
     * @param string $header
     * @return array
     */
    public function getHeader($header)
    {
        $header = ArrayUtility::getValueByPath($this->maiLData, 'Content/Headers/'.$header);
        return array_map(new ImapDecoder(), $header);
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return array
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * @return string
     */
    public function getSender()
    {
        return $this->sender;
    }
}