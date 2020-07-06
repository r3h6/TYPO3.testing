<?php

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
     * @Given I submit form :form
     * @param string $form
     */
    public function iSubmitForm(string $form): void
    {
        $this->submitForm($form, []);
    }

    /**
     * @Given I submit form :form with :values
     * @param string $form
     * @param array $values
     */
    public function iSubmitFormWithValues(string $form, array $values): void
    {
        $this->submitForm($form, $values);
    }

    /**
     * @When I select :value from :field
     * @param string $value
     * @param string $field
     */
    public function iSelectFrom(string $value, string $field): void
    {
        $this->selectOption($field, $value);
    }

    /**
     * @When I check option :option
     * @param string $option
     */
    public function iCheckOption(string $option): void
    {
        $this->checkOption($option);
    }

    /**
     * @When I uncheck option :option
     * @param string $option
     */
    public function iUncheckOption(string $option): void
    {
        $this->uncheckOption($option);
    }

    /**
     * @When I attach :field the :file
     * @param string $field
     * @param string $filename
     */
    public function iAttachFile(string $field, string $filename): void
    {
        $this->attachFile($field, $filename);
    }
}