<?php

namespace TDevAgency\CheckboxUa\Entities\Responses;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use TDevAgency\CheckboxUa\Entities\GoodEntity;
use TDevAgency\CheckboxUa\Traits\HasTaxes;
use TDevAgency\CheckboxUa\Traits\ResponseEntity;

class ReceiptGoodResponseEntity implements Arrayable
{
    use ResponseEntity;
    use HasTaxes;

    private GoodEntity $good;
    private ?string $good_id = null;
    private int $sum;
    private int $quantity;
    private bool $is_return;
    private Collection $taxes;
    private Collection $discounts;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if ($value !== null && property_exists(self::class, $key)) {
                if ($key === 'good') {
                    $this->good = new GoodEntity($value);
                } elseif ($key === 'taxes') {
                    $this->setTaxes($value);
                } else {
                    $this->$key = $value;
                }
            }
        }
    }
}
