<?php

namespace TDevAgency\CheckboxUa\Entities\Requests;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use TDevAgency\CheckboxUa\Traits\RequestEntity;

class ReceiptRequestEntity implements Arrayable
{
    use RequestEntity;

    private string $id;

    private string $cashier_name;

    private string $departament;

    private Collection $goods;

    private ?string $delivery = null;

    private Collection $discounts;

    private Collection $payments;

    private bool $rounding = false;

    private ?string $header = null;

    private ?string $footer = null;

    private ?string $barcode = null;

    private ?string $order_id = null;

    private ?string $related_receipt_id = null;

    private ?string $previous_receipt_id = null;

    private bool $technical_return = false;

    private array $context = [];

    private bool $is_pawnshop = false;

}
