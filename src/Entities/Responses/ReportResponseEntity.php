<?php

namespace TDevAgency\CheckboxUa\Entities\Responses;

use DateTime;
use DateTimeInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use TDevAgency\CheckboxUa\Traits\HasPayments;
use TDevAgency\CheckboxUa\Traits\HasTaxes;
use TDevAgency\CheckboxUa\Traits\ResponseEntity;

class ReportResponseEntity implements Arrayable
{
    use ResponseEntity;
    use HasPayments;
    use HasTaxes;

    private string $id;

    private int $serial;

    private bool $is_z_report;

    private Collection $payments;

    private Collection $taxes;

    private int $sell_receipts_count;

    private int $return_receipts_count;

    private int $transfers_count;

    private int $transfers_sum;

    private int $balance;

    private int $initial;

    private ?DateTimeInterface $created_at = null;

    private ?DateTimeInterface $updated_at = null;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if ($value !== null && property_exists(self::class, $key)) {
                if ($key === 'payments') {
                    $this->setPayments($value);
                } elseif ($key === 'taxes') {
                    $this->setTaxes($value);
                } elseif (in_array($key, ['created_at', 'updated_at', 'updated_date'])) {
                    $this->$key = new DateTime($value);
                } else {
                    $this->$key = $value;
                }
            }
        }
    }
}
