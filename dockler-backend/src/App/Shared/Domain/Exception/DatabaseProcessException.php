<?php

declare(strict_types=1);

namespace App\App\Shared\Domain\Exception;

class DatabaseProcessException extends AbstractDomainException
{
    public function errorFormat(): array
    {
        $this->setMessage($this->getMessage());

        return parent::errorFormat();
    }
}
