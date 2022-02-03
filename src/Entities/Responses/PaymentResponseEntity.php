<?php

namespace TDevAgency\CheckboxUa\Entities\Responses;

use Illuminate\Contracts\Support\Arrayable;
use TDevAgency\CheckboxUa\Traits\ResponseEntity;

class PaymentResponseEntity implements Arrayable
{
    use ResponseEntity;

    private string $id;

    private int $code;

    private string $type;

    private string $label;

    private int $sell_sum;

    private int $return_sum;

    private int $service_in;

    private int $service_out;
}
