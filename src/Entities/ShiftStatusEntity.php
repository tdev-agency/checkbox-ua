<?php

namespace TDevAgency\CheckboxUa\Entities;

use TDevAgency\CheckboxUa\Interfaces\ShiftStatusInterface;

class ShiftStatusEntity implements ShiftStatusInterface
{
    private string $status;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public function __toString(): string
    {
        return $this->status;
    }

    public function isCreated(): bool
    {
        return $this->status === self::CREATED;
    }
}
