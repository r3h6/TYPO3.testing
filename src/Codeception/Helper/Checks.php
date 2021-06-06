<?php

declare(strict_types=1);

namespace R3H6\Typo3Testing\Codeception\Helper;

trait Checks
{
    /**
     * @Then I see :text
     */
    public function iSee(string $text): void
    {
        $this->see($text);
    }

    /**
     * @Then I see :text in element :element
     */
    public function iSeeInElement(string $text, string $selector): void
    {
        $this->see($text, $selector);
    }

    /**
     * @Then I am on :url
     */
    public function iSeeInCurrentUrl(string $url): void
    {
        $this->seeInCurrentUrl($url);
    }

    /**
     * @Then I see element :selector
     */
    public function iSeeElement(string $selector): void
    {
        $this->seeElement($selector);
    }

    /**
     * @Then I do not see :text
     * @Then I don't see :text
     */
    public function iDontSee(string $text): void
    {
        $this->dontSee($text);
    }

    /**
     * @Then I do not see element :selector
     * @Then I don't see element :selector
     */
    public function iDontSeeElement(string $selector): void
    {
        $this->dontSeeElement($selector);
    }

    /**
     * @Then I see a link with text :text
     */
    public function iSeeLink(string $text): void
    {
        $this->seeLink($text);
    }

    /**
     * @Then I see :text in page source
     */
    public function iSeeInPageSource(string $text): void
    {
        $this->seeInPageSource($text);
    }

    /**
     * @Then I see :value in field :field
     */
    public function iSeeInField(string $value, string $field): void
    {
        $this->seeInField($field, $value);
    }

    /**
     * @Then I see checkbox :selector is checked
     */
    public function iSeeCheckboxIsChecked(string $selector): void
    {
        $this->seeCheckboxIsChecked($selector);
    }

    /**
     * @Then I see checkbox :selector is unchecked
     * @Then I see checkbox :selector is not checked
     */
    public function iDontSeeCheckboxIsChecked(string $selector): void
    {
        $this->dontSeeCheckboxIsChecked($selector);
    }

    /**
     * @Then I see exactly :expected elements :selector
     */
    public function iSeeNumberOfElements(int $expected, string $selector): void
    {
        $this->seeNumberOfElements($selector, $expected);
    }

    /**
     * @Then I see exactly 1 element :selector
     * @Then I see exactly one element :selector
     */
    public function iSeeOneElement(string $selector): void
    {
        $this->seeNumberOfElements($selector, 1);
    }

    /**
     * @Then I see at least :number elements :selector
     */
    public function iSeeMinNumberOfElements(string $number, string $selector): void
    {
        $this->seeNumberOfElements($selector, [$number, PHP_INT_MAX]);
    }

    /**
     * @Then I see at least 1 element :selector
     * @Then I see at least one element :selector
     */
    public function iSeeMinOneElement(string $selector): void
    {
        $this->seeNumberOfElements($selector, [1, PHP_INT_MAX]);
    }

    /**
     * @Then I see in title :title
     */
    public function iSeeInTitle(string $title): void
    {
        $this->seeInTitle($title);
    }
}
