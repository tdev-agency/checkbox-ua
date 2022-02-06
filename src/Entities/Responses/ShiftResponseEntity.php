<?php

namespace TDevAgency\CheckboxUa\Entities\Responses;

use DateTime;
use DateTimeInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use TDevAgency\CheckboxUa\Entities\ShiftStatusEntity;
use TDevAgency\CheckboxUa\Traits\HasTaxes;
use TDevAgency\CheckboxUa\Traits\ResponseEntity;

class ShiftResponseEntity implements Arrayable
{
    use ResponseEntity;
    use HasTaxes;

    private string $id;
    private int $serial;
    private ShiftStatusEntity $status;
    private ?ReportResponseEntity $z_report = null;
    private ?DateTimeInterface $opened_at = null;
    private ?DateTimeInterface $closed_at = null;
    private ?DateTimeInterface $created_at;
    private Collection $taxes;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if ($value !== null && property_exists(self::class, $key)) {
                if ($key === 'status') {
                    $this->$key = new ShiftStatusEntity($value);
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
        }
    }

    /**
     * @return ShiftStatusEntity
     */
    public function getStatus(): ShiftStatusEntity
    {
        return $this->status;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
