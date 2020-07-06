<?php

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

    /**
     * Mailhog constructor.
     * @param ModuleContainer $moduleContainer
     * @param mixed[]|null $config
     */
    public function __construct(ModuleContainer $moduleContainer, array $config = null)
    {
        parent::__construct($moduleContainer, $config);
        $this->mailHogClient = new MailHogClient($config['base_uri'] ?? null);
    }

    public function clearInbox(): void
    {
        $this->mailHogClient->deleteAllMessages();
    }


    public function searchMail($subject, $recipient = null, $sender = null): Mail
    {
        $mails = ($recipient === null) ?
            $this->mailHogClient->search('containing', $subject):
            $this->mailHogClient->search('to', $recipient);

        foreach ($mails as $mail) {

            if ($subject && strpos($mail->getSubject(), $subject) === false) {
                throw new \Exception('Sb');
                continue;
            }
            if ($sender && strpos($mail->getSender(), $sender) === false) {
                throw new \Exception('Sender');
                continue;
            }
            if ($recipient && strpos(implode(',', $mail->getRecipients()), $recipient) === false) {
                throw new \Exception('REc');
                continue;
            }
            return $mail;
        }
        throw new \Exception('Could not find mail', 1592944498013);
    }

    public function openMail ($subject)
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

        $file = 'typo3temp/assets/'.uniqid('mail', false) . '.html';
        file_put_contents('web/typo3temp/tests/acceptance/web/'.$file, $html);

        /** \Codeception\Module\WebDriver $wd */
        $wd = $this->getModule('WebDriver');
        $wd->amOnPage('/'.$file);
    }
}
