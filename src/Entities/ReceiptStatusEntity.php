<?php

namespace TDevAgency\CheckboxUa\Entities;

use TDevAgency\CheckboxUa\Interfaces\ReceiptStatusInterface;

class ReceiptStatusEntity implements ReceiptStatusInterface
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
}
