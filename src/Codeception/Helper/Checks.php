<?php

declare(strict_types=1);

namespace R3H6\Typo3Testing\Codeception\Helper;

trait Checks
{
    /**
     * @Then I should see :text
     * @Then I see :text
     */
    public function iSee(string $text): void
    {
        $this->see($text);
    }

    /**
     * @Then I should see :text in :element element
     */
    public function iSeeInElement(string $text, string $selector): void
    {
        $this->see($text, $selector);
    }

    /**
     * @Then I should be on :url
     */
    public function iSeeInCurrentUrl(string $url): void
    {
        $this->seeInCurrentUrl($url);
    }

    /**
     * @Then I should see an :selector element
     */
    public function iSeeElement(string $selector): void
    {
        $this->seeElement($selector);
    }

    /**
     * @Then I should not see :text
     */
    public function iDontSee(string $text): void
    {
        $this->dontSee($text);
    }

    /**
     * @Then I should not see an :selector element
     */
    public function iDontSeeElement(string $selector): void
    {
        $this->dontSeeElement($selector);
    }

    /**
     * @Then I should see a link with the text :text
     */
    public function iSeeLink(string $text): void
    {
        $this->seeLink($text);
    }

    /**
     * @Then I should see :text in page source
     */
    public function iSeeInPageSource(string $text): void
    {
        $this->seeInPageSource($text);
    }

    /**
     * @Then I should see :value in :field field
     */
    public function iSeeInField(string $value, string $field): void
    {
        $this->seeInField($field, $value);
    }

    /**
     * @Then I should see checkbox :selector is checked
     */
    public function iSeeCheckboxIsChecked(string $selector): void
    {
        $this->seeCheckboxIsChecked($selector);
    }

    /**
     * @Then I should see checkbox :selector is unchecked
     */
    public function iDontSeeCheckboxIsChecked(string $selector): void
    {
        $this->dontSeeCheckboxIsChecked($selector);
    }

    /**
     * @Then I should see :expected :selector elements
     */
    public function iSeeNumberOfElements(int $expected, string $selector): void
    {
        $this->seeNumberOfElements($selector, $expected);
    }

    /**
     * @Then I accept the open popup
     */
    public function iAcceptPopup(): void
    {
        $this->acceptPopup();
    }

    /**
     * @Then I should see at least :number :selector elements
     */
    public function iShouldSeeMinNumberOfElements(string $number, string $selector): void
    {
        $this->seeNumberOfElements($selector, [$number, PHP_INT_MAX]);
    }
}
