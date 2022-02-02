<?php

namespace TDevAgency\CheckboxUa\Entities\Interfaces;

interface ShiftStatusInterface
{
    public const CREATED = 'CREATED';
    public const OPENING = 'OPENING';
    public const OPENED = 'OPENED';
    public const CLOSING = 'CLOSING';
    public const CLOSED = 'CLOSED';
}
