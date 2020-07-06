<?php

namespace R3H6\Typo3Testing\Codeception\Helper;

use Facebook\WebDriver\WebDriverKeys;

trait Actions
{
    /**
     * @When I click on :element
     * @param string $element
     */
    public function iClickOn(string $element): void
    {
        $this->click($element);
    }

    /**
     * @When I press enter on :element
     * @param string $element
     */
    public function iPressEnter(string $element): void
    {
        $this->pressKey($element, WebDriverKeys::ENTER);
    }

    /**
     * @When I click on :element inside :selector
     * @param string $element
     * @param string $id
     */
    public function iClickOnInside(string $element, string $selector): void
    {
        $this->click($element, $selector);
    }

    /**
     * @When I execute JS :script
     * @param string $script
     */
    public function iExecuteJS(string $script): void
    {
        $this->executeJS($script);
    }

    /**
     * @When I move mouse over :select
     * @param string $select
     */
    public function iMoveMouseOver(string $select): void
    {
        $this->moveMouseOver($select);
    }

}