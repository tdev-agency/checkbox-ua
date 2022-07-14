<?php

namespace TDevAgency\CheckboxUa\Interfaces;

interface ReceiptStatusInterface
{
    public const CREATED = 'CREATED';
    public const DONE = 'DONE';
    public const ERROR = 'ERROR';
    public const CANCELLATION = 'CANCELLATION';
    public const CANCELLED = 'CANCELLED';

    public function __toString(): string;
}
