<?php

declare(strict_types=1);

namespace App\UserInterface\View;

class SingleErrorView extends ErrorsView
{
    public function __construct(string $error)
    {
        parent::__construct(['data' => [$error]]);
    }
}
