<?php

namespace TDevAgency\CheckboxUa\Entities\Requests;

use DateTimeInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use TDevAgency\CheckboxUa\Interfaces\CreateEntityInterface;
use TDevAgency\CheckboxUa\Traits\Createable;
use TDevAgency\CheckboxUa\Traits\RequestEntity;

class ReportRequestEntity implements Arrayable, CreateEntityInterface
{
    use RequestEntity;
    use Createable;


    private ?string $id = null;
    private ?int $serial = null;
    private Collection $payments;
    private Collection $taxes;
    private int $sell_receipts_count;
    private int $return_receipts_count;
    private ?string $last_receipt_id = null;
    private int $initial;
    private int $balance;
    private int $sales_round_up = 0;
    private int $sales_round_down = 0;
    private int $returns_round_up = 0;
    private int $returns_round_down = 0;
    private ?DateTimeInterface $created_at = null;

    public function __construct(array $data)
    {
        $this->payments = new Collection();
        $this->taxes = new Collection();
        $this->setData($data);
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getSerial(): ?int
    {
        return $this->serial;
    }

    /**
     * @return Collection
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    /**
     * @return Collection
     */
    public function getTaxes(): Collection
    {
        return $this->taxes;
    }

    /**
     * @return int
     */
    public function getSellReceiptsCount(): int
    {
        return $this->sell_receipts_count;
    }

    /**
     * @return int
     */
    public function getReturnReceiptsCount(): int
    {
        return $this->return_receipts_count;
    }

    /**
     * @return string|null
     */
    public function getLastReceiptId(): ?string
    {
        return $this->last_receipt_id;
    }

    /**
     * @return int
     */
    public function getInitial(): int
    {
        return $this->initial;
    }

    /**
     * @return int
     */
    public function getBalance(): int
    {
        return $this->balance;
    }

    /**
     * @return int
     */
    public function getSalesRoundUp(): int
    {
        return $this->sales_round_up;
    }

    /**
     * @return int
     */
    public function getSalesRoundDown(): int
    {
        return $this->sales_round_down;
    }

    /**
     * @return int
     */
    public function getReturnsRoundUp(): int
    {
        return $this->returns_round_up;
    }

    /**
     * @return int
     */
    public function getReturnsRoundDown(): int
    {
        return $this->returns_round_down;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->created_at;
    }


}
