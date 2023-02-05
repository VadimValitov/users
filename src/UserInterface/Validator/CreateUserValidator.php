<?php

declare(strict_types=1);

namespace App\UserInterface\Validator;

use App\Infrastructure\Validator\Validator;
use Laminas\InputFilter\Input;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\Regex;
use Laminas\Validator\StringLength;

class CreateUserValidator extends Validator
{
    protected function configureOptions(): void
    {
        $firstName = new Input('name');
        $firstName->setBreakOnFailure(false)
            ->getValidatorChain()
            ->attach(new StringLength(['min' => 8, 'max' => 64]))
            ->attach(new Regex('/^[0-9a-z]+$/'));

        $this->inputFilter->add($firstName);

        $email = new Input('email');
        $email->setBreakOnFailure(false)
            ->getValidatorChain()
            ->attach(new EmailAddress());
        $email->getFilterChain()
            ->attachByName('stringtrim');

        $this->inputFilter->add($email);

        $notes = new Input('notes');
        $notes->setBreakOnFailure(false)
            ->setRequired(false)
            ->setFallbackValue(null);

        $this->inputFilter->add($notes);
    }
}
