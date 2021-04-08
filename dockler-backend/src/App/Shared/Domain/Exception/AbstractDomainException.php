<?php

declare(strict_types=1);

namespace App\App\Shared\Domain\Exception;

abstract class AbstractDomainException extends \Exception implements DomainExceptionInterface
{
    use ErrorFormatTrait;
}
