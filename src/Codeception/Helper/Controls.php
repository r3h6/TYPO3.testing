<?php

declare(strict_types=1);

namespace R3H6\Typo3Testing\Codeception\Helper;

trait Controls
{
    /**
     * @Given I am on page :page
     */
    public function iAmOn(string $page): void
    {
        if (strpos($page, 'http') === 0) {
            $this->amOnUrl($page);
        } else {
            $this->amOnPage($page);
        }
    }

    /**
     * @Given I am logged in as :username
     */
    public function iAmLoggedInAs($username): void
    {
        $this->loginAs($username);
    }

    /**
     * @Given I wait for the text :text
     * @Given /^I wait for the text (?P<pattern>"(?:[^"]|\\")*")$/
     */
    public function iWaitForTheText(string $text): void
    {
        $text = str_replace('\\', '', $text);
        $this->waitForText($text);
    }

    /**
     * @Given I wait for :seconds seconds
     * @Given I wait for :seconds second
     */
    public function iWaitForSeconds(int $seconds): void
    {
        $this->wait($seconds);
    }

    /**
     * @Given I wait for invisible :selector in :seconds
     */
    public function iWaitForElementNotVisible(string $selector, int $seconds): void
    {
        $this->waitForElementNotVisible($selector, $seconds);
    }
}
