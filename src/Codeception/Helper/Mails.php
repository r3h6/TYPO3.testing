<?php

declare(strict_types=1);

namespace R3H6\Typo3Testing\Codeception\Helper;

use Behat\Gherkin\Node\TableNode;
use Codeception\Util\ActionSequence;

trait Mails
{
    /**
     * @Given My inbox is empty
     * @When I clear my inbox
     */
    public function iClearInbox(): void
    {
        $this->clearInbox();
    }

    /**
     * @Then I see in my inbox the mail :subject for :recipient from :sender
     */
    public function iSeeMailInInbox($subject, $recipient, $sender): void
    {
        $this->searchMail($subject, $recipient, $sender);
    }

    /**
     * @When I open the mail :subject
     */
    public function iOpenMail($subject): void
    {
        $this->openMail($subject);
    }
}
