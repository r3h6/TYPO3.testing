<?php

declare(strict_types=1);

namespace R3H6\Typo3Testing\Codeception\Helper;

use Behat\Gherkin\Node\TableNode;
use Codeception\Util\ActionSequence;

trait Forms
{
    /**
     * @When I fill out :field with :value
     */
    public function iFillWith($field, $value)
    {
        $this->fillField($field, $value);
    }

    /**
     * @When I fill out the form :form with:
     */
    public function iFillOutFormWidth($form, TableNode $data)
    {
        $actions = ActionSequence::build();
        foreach ($data as $row) {
            $actions->fillField($row['field'], $row['value']);
        }
        $this->performOn($form, $actions);
    }

    /**
     * @When I submit the form :form
     */
    public function iSubmitForm(string $form): void
    {
        $this->submitForm($form, []);
    }

    /**
     * @When I submit the form :form with :values
     */
    public function iSubmitFormWithValues(string $form, array $values): void
    {
        $this->submitForm($form, $values);
    }

    /**
     * @When I select :value from :field
     */
    public function iSelectFrom(string $value, string $field): void
    {
        $this->selectOption($field, $value);
    }

    /**
     * @When I check option :option
     */
    public function iCheckOption(string $option): void
    {
        $this->checkOption($option);
    }

    /**
     * @When I uncheck option :option
     */
    public function iUncheckOption(string $option): void
    {
        $this->uncheckOption($option);
    }

    /**
     * @When I attach :file to :field
     */
    public function iAttachFile(string $file, string $field): void
    {
        $this->attachFile($field, $file);
    }
}
