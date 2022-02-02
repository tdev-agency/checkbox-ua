<?php

namespace TDevAgency\CheckboxUa\Entities\Requests;

use TDevAgency\CheckboxUa\Entities\DeliveryEntity;
use TDevAgency\CheckboxUa\Entities\DiscountEntity;
use TDevAgency\CheckboxUa\Entities\ItemEntity;
use TDevAgency\CheckboxUa\Entities\Traits\RequestEntity;
use TDevAgency\CheckboxUa\Entities\EntityInterface;

class ReceiptRequestEntity implements EntityInterface
{
    use RequestEntity;

    private string $id;

    private string $cashier_name;

    private string $departament;

    /** @var ItemEntity[] */
    private array $goods;

    private ?DeliveryEntity $delivery = null;

    /** @var DiscountEntity[] */
    private array $discounts = [];

    private array $payments = [];

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
