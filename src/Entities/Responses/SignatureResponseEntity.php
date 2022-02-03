<?php

namespace TDevAgency\CheckboxUa\Entities\Responses;

use TDevAgency\CheckboxUa\Traits\ResponseEntity;

class SignatureResponseEntity
{
    use ResponseEntity;

    private bool $online = false;
    private string $type;
}
