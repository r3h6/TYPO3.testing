<?php

namespace R3H6\Typo3Testing\Codeception\Helper;

use Behat\Gherkin\Node\TableNode;
use Codeception\Util\ActionSequence;

trait Mails
{
    /**
     * @Given I cleared my inbox
     */
    public function iClearInbox()
    {
        $this->clearInbox();
    }

    /**
     * @Then I should see in my inbox the mail :subject for :recipient from :sender
     */
    public function iSeeMailInInbox($subject, $recipient, $sender)
    {
        $this->searchMail($subject, $recipient, $sender);
    }

    /**
     * @Then I open the mail :subject
     */
    public function iOpenMail($subject)
    {
        $this->openMail($subject);
    }
}