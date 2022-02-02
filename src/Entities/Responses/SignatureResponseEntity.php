<?php

namespace TDevAgency\CheckboxUa\Entities\Responses;

use TDevAgency\CheckboxUa\Entities\Traits\ResponseEntity;

class SignatureResponseEntity
{
    use ResponseEntity;

    private bool $online = false;
    private string $type;

}
