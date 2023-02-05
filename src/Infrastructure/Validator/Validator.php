<?php

declare(strict_types=1);

namespace App\Infrastructure\Validator;

use Laminas\InputFilter\InputFilter;

use function array_values;

abstract class Validator
{
    protected readonly InputFilter $inputFilter;

    public function __construct()
    {
        $this->inputFilter = new InputFilter();
        $this->configureOptions();
    }

    abstract protected function configureOptions(): void;

    public function validate(array $data): array
    {
        $this->inputFilter->setData($data);

        if (!$this->inputFilter->isValid()) {
            return [];
        }

        return $this->inputFilter->getValues();
    }

    public function getErrors(): array
    {
        $errors = [];

        foreach ($this->inputFilter->getInvalidInput() as $field => $input) {
            $errors[$field] = array_values($input->getMessages());
        }

        return $errors;
    }
}
