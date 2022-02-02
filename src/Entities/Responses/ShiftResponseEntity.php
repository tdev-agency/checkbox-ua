<?php

namespace TDevAgency\CheckboxUa\Entities\Responses;

use DateTime;
use DateTimeInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use TDevAgency\CheckboxUa\Traits\HasTaxes;
use TDevAgency\CheckboxUa\Traits\ResponseEntity;

class ShiftResponseEntity implements Arrayable
{
    use ResponseEntity;
    use HasTaxes;

    private string $id;
    private int $serial;
    private ShiftStatusResponseEntity $status;
    private ?ReportResponseEntity $z_report = null;
    private ?DateTimeInterface $opened_at = null;
    private ?DateTimeInterface $closed_at = null;
    private ?DateTimeInterface $created_at;
    private Collection $taxes;

    public function __construct(array $data = [])
    {
        array_walk($data, function ($value, $key) {
            if ($value !== null && property_exists(self::class, $key)) {
                if ($key === 'status') {
                    $this->$key = new ShiftStatusResponseEntity($value);
                } elseif ($key === 'z_report') {
                    $this->$key = new ReportResponseEntity($value);
                } elseif ($key === 'taxes') {
                    $this->setTaxes($value);
                } elseif (in_array($key, ['created_at', 'opened_at', 'closed_at'])) {
                    $this->$key = new DateTime($value);
                } else {
                    $this->$key = $value;
                }
            }
        });
    }

    /**
     * @return ShiftStatusResponseEntity
     */
    public function getStatus(): ShiftStatusResponseEntity
    {
        return $this->status;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
