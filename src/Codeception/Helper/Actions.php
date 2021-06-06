<?php

declare(strict_types=1);

namespace R3H6\Typo3Testing\Codeception\Helper;

use Facebook\WebDriver\WebDriverKeys;

trait Actions
{
    /**
     * @When I click on :element
     */
    public function iClickOn(string $element): void
    {
        $this->click($element);
    }

    /**
     * @When I press enter on :element
     */
    public function iPressEnter(string $element): void
    {
        $this->pressKey($element, WebDriverKeys::ENTER);
    }

    /**
     * @When I click on :element inside :selector
     */
    public function iClickOnInside(string $element, string $selector): void
    {
        $this->click($element, $selector);
    }

    /**
     * @When I execute JS :script
     */
    public function iExecuteJS(string $script): void
    {
        $this->executeJS($script);
    }

    /**
     * @When I move mouse over :select
     */
    public function iMoveMouseOver(string $select): void
    {
        $this->moveMouseOver($select);
    }

    /**
     * @When I accept the open popup
     */
    public function iAcceptPopup(): void
    {
        $this->acceptPopup();
    }
}
