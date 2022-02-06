<?php

namespace TDevAgency\CheckboxUa\Entities\Responses;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use TDevAgency\CheckboxUa\Entities\ReceiptTypeEntity;
use TDevAgency\CheckboxUa\Traits\ResponseEntity;

class ReceiptResponseEntity implements Arrayable
{
    use ResponseEntity;

    private string $id;
    private ReceiptTypeEntity $type;
    private ?TransactionResponseEntity $transaction = null;
    private ?int $serial = null;
}
