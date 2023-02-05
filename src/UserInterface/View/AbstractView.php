<?php

declare(strict_types=1);

namespace App\UserInterface\View;

use JsonSerializable;

abstract class AbstractView implements JsonSerializable
{
    abstract public function toArray(): array;

    final public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
