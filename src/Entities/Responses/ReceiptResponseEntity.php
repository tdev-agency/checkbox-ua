<?php

namespace TDevAgency\CheckboxUa\Entities\Responses;

use DateTime;
use DateTimeInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use TDevAgency\CheckboxUa\Entities\ReceiptStatusEntity;
use TDevAgency\CheckboxUa\Entities\ReceiptTypeEntity;
use TDevAgency\CheckboxUa\Traits\HasPayments;
use TDevAgency\CheckboxUa\Traits\HasTaxes;
use TDevAgency\CheckboxUa\Traits\ResponseEntity;

class ReceiptResponseEntity implements Arrayable
{
    use ResponseEntity;
    use HasPayments;
    use HasTaxes;

    private string $id;
    private ReceiptTypeEntity $type;
    private ?TransactionResponseEntity $transaction = null;
    private int $serial;
    private ReceiptStatusEntity $status;
    private ReceiptGoodResponseEntity $goods;
    private Collection $payments;
    private Collection $taxes;
    private Collection $discounts;
    private int $total_sum;
    private int $total_payment;
    private int $total_rest;
    private ?string $fiscal_code = null;
    private ?DateTimeInterface $fiscal_date = null;
    private ?DateTimeInterface $delivered_at = null;
    private DateTimeInterface $created_at;
    private ?DateTimeInterface $updated_at = null;
    private ?DateTimeInterface $sent_dps_at = null;
    private ?string $order_id = null;
    private ?string $header = null;
    private ?string $footer = null;
    private ?string $barcode = null;
    private ?string $tax_url = null;
    private ?string $related_receipt_id = null;
    private ?string $control_number = null;
    private bool $is_created_offline = false;
    private bool $is_sent_dps = false;
    private bool $technical_return = false;
    // private ?CurrencyExchangeResponseEntity $currency_exchange = null;
    private ?ShiftResponseEntity $shift = null;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if ($value !== null && property_exists(self::class, $key)) {
                if ($key === 'payments') {
                    $this->setPayments($value);
                } elseif ($key === 'taxes') {
                    $this->setTaxes($value);
                } elseif ($key === 'transaction') {
                    $this->$key = new TransactionResponseEntity($value);
                } elseif ($key === 'type') {
                    $this->$key = new ReceiptTypeEntity($value);
                } elseif ($key === 'status') {
                    $this->$key = new ReceiptStatusEntity($value);
                } elseif ($key === 'status') {
                    $this->$key = new ReceiptStatusEntity($value);
                } elseif (in_array($key, ['created_at', 'updated_at', 'fiscal_date', 'delivered_at', 'sent_dps_at'])) {
                    $this->$key = new DateTime($value);
                } else {
                    $this->$key = $value;
                }
            }
        }
    }
}
