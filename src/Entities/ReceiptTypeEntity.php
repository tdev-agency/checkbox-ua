<?php

namespace TDevAgency\CheckboxUa\Entities;

use TDevAgency\CheckboxUa\Interfaces\ReceiptTypeInterface;

class ReceiptTypeEntity implements ReceiptTypeInterface
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

    public function isSell(): bool
    {
        return $this->status === self::SELL_TYPE;
    }
}
