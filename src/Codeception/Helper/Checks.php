<?php

namespace R3H6\Typo3Testing\Codeception\Helper;

trait Checks
{
    /**
     * @Then I should see :text
     * @Then I see :text
     * @param string $text
     */
    public function iSee(string $text)
    {
        $this->see($text);
    }

    /**
     * @Then I should see :text in :element element
     * @param string $text
     * @param string $selector
     */
    public function iSeeInElement(string $text, string $selector): void
    {
        $this->see($text, $selector);
    }

    /**
     * @Then I should be on :url
     * @param string $url
     */
    public function iSeeInCurrentUrl(string $url)
    {
        $this->seeInCurrentUrl($url);
    }

    /**
     * @Then I should see an :selector element
     * @param string $selector
     */
    public function iSeeElement(string $selector)
    {
        $this->seeElement($selector);
    }

    /**
     * @Then I should not see :text
     * @param string $text
     */
    public function iDontSee(string $text)
    {
        $this->dontSee($text);
    }

    /**
     * @Then I should not see an :selector element
     * @param string $selector
     */
    public function iDontSeeElement(string $selector)
    {
        $this->dontSeeElement($selector);
    }

    /**
     * @Then I should see a link with the text :text
     * @param string $text
     */
    public function iSeeLink(string $text)
    {
        $this->seeLink($text);
    }

    /**
     * @Then I should see :text in page source
     * @param string $text
     */
    public function iSeeInPageSource(string $text)
    {
        $this->seeInPageSource($text);
    }

    /**
     * @Then I should see :value in :field field
     * @param string $value
     * @param string $field
     */
    public function iSeeInField(string $value, string $field)
    {
        $this->seeInField($field, $value);
    }

    /**
     * @Then I should see checkbox :selector is checked
     * @param string $selector
     */
    public function iSeeCheckboxIsChecked(string $selector)
    {
        $this->seeCheckboxIsChecked($selector);
    }

    /**
     * @Then I should see checkbox :selector is unchecked
     * @param string $selector
     */
    public function iDontSeeCheckboxIsChecked(string $selector)
    {
        $this->dontSeeCheckboxIsChecked($selector);
    }

    /**
     * @Then I should see :expected :selector elements
     * @param int $expected
     * @param string $selector
     */
    public function iSeeNumberOfElements(int $expected, string $selector)
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
     * @param string $number
     * @param string $selector
     */
    public function iShouldSeeMinNumberOfElements(string $number, string $selector): void
    {
        $this->seeNumberOfElements($selector, [$number, PHP_INT_MAX]);
    }
}