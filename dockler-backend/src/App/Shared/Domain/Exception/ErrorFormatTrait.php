<?php

declare(strict_types=1);

namespace App\App\Shared\Domain\Exception;

trait ErrorFormatTrait
{
    protected array $errorFormat = [
        'path' => '',
        'message' => '',
        'invalid_value' => '',
    ];

    public function errorFormat(): array
    {
        return $this->errorFormat;
    }

    public function setPath($path): void
    {
        $this->errorFormat['path'] = $path;
    }

    public function setMessage(string $message): void
    {
        $this->errorFormat['message'] = $message;
    }

    public function setInvalidValue($invalidValue): void
    {
        $this->errorFormat['invalid_value'] = $invalidValue;
    }
}
