<?php

declare(strict_types=1);

namespace R3H6\Typo3Testing\Codeception\Module;

use Codeception\Module;
use Codeception\Lib\ModuleContainer;
use R3H6\Typo3Testing\MailHog\Mail;
use R3H6\Typo3Testing\MailHog\MailHogClient;

class MailHog extends Module
{
    /**
     * @var MailHogClient
     */
    protected $mailHogClient;

    public function __construct(ModuleContainer $moduleContainer, array $config = null)
    {
        parent::__construct($moduleContainer, $config);
        $this->mailHogClient = new MailHogClient($config['base_uri'] ?? null);
    }

    public function clearInbox(): void
    {
        $this->mailHogClient->deleteAllMessages();
    }

    public function searchMail(string $subject, string $recipient = null, string $sender = null): Mail
    {
        $mails = ($recipient === null) ?
            $this->mailHogClient->search('containing', $subject) :
            $this->mailHogClient->search('to', $recipient);

        foreach ($mails as $mail) {
            if ($subject && strpos($mail->getSubject(), $subject) === false) {
                continue;
            }
            if ($sender && strpos($mail->getSender(), $sender) === false) {
                continue;
            }
            if ($recipient && strpos(implode(',', $mail->getRecipients()), $recipient) === false) {
                continue;
            }
            return $mail;
        }
        throw new \Exception('Could not find mail', 1592944498013);
    }

    public function openMail(string $subject): void
    {
        $mail = $this->searchMail($subject);
        $body = $mail->getBody();

        if (preg_match('#<html[^>]*>.*</html>#si', $body, $matches)) {
            $html = $matches[0];
        } else {
            $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@';
            $html = preg_replace($url, '<a href="http$2://$4">$0</a>', $body);
            $html = '<pre>'.$html.'</pre>';
        }

        $root = $this->_getConfig('test_root');
        $file = 'typo3temp/assets/'.uniqid('mail', false) . '.html';
        file_put_contents($root . '/web/' . $file, $html);

        /** @var \Codeception\Module\WebDriver $wd */
        $wd = $this->getModule('WebDriver');
        $wd->amOnPage('/'.$file);
    }
}
