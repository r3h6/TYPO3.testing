<?php

declare(strict_types=1);

namespace R3H6\Typo3Testing\Codeception\Helper;

trait Browser
{
    /**
     * @When I move back
     */
    public function iMoveBack(): void
    {
        $this->moveBack();
    }

    /**
     * @When I move forward
     */
    public function iMoveForward(): void
    {
        $this->moveForward();
    }

    /**
     * @When I reload the page
     */
    public function iReloadPage(): void
    {
        $this->reloadPage();
    }

    /**
     * @When I scroll to :selector
     */
    public function iScrollTo(string $selector)
    {
        $this->scrollTo($selector);
    }

    /**
     * @When I resize window to :width x :height
     */
    public function iResizeWindow(int $width, int $height)
    {
        $this->resizeWindow($width, $height);
    }
}
