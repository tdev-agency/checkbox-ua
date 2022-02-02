<?php

namespace TDevAgency\CheckboxUa\Entities\Responses;

use DateTimeInterface;
use Illuminate\Contracts\Support\Arrayable;
use TDevAgency\CheckboxUa\Entities\Entity;
use TDevAgency\CheckboxUa\Entities\EntityInterface;
use TDevAgency\CheckboxUa\Entities\Traits\ResponseEntity;

class TaxResponseEntity implements Arrayable
{
    use ResponseEntity;

    private string $id;

    private int $code;

    private string $label;

    private string $symbol;

    private float $rate;

    private int $sell_sum = 0;

    private int $return_sum = 0;

    private int $sales_turnover = 0;

    private int $returns_turnover = 0;

    private ?DateTimeInterface $created_at = null;

    private ?DateTimeInterface $setup_date = null;


}
