<?php

namespace TDevAgency\CheckboxUa\Entities\Responses;

use TDevAgency\CheckboxUa\Entities\Entity;
use TDevAgency\CheckboxUa\Entities\EntityInterface;
use TDevAgency\CheckboxUa\Entities\Interfaces\ShiftStatusInterface;
use TDevAgency\CheckboxUa\Entities\Traits\ResponseEntity;

class ShiftStatusResponseEntity implements ShiftStatusInterface
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
