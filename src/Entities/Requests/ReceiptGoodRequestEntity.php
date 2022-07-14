<?php

namespace TDevAgency\CheckboxUa\Entities\Requests;

use Illuminate\Support\Collection;
use TDevAgency\CheckboxUa\Entities\GoodEntity;
use TDevAgency\CheckboxUa\Interfaces\CreateEntityInterface;
use TDevAgency\CheckboxUa\Traits\Arrayable;
use TDevAgency\CheckboxUa\Traits\Createable;

class ReceiptGoodRequestEntity implements CreateEntityInterface
{
    use Arrayable;
    use Createable;

    public array $required = [
        'good',
        'quantity'
    ];

    private GoodEntity $good;
    private ?string $good_id = null;
    private int $quantity;
    private bool $is_return = false;
    private Collection $discounts;

    public function __construct(array $data = [])
    {
        $this->discounts = Collection::make();

        $this->setData($data)->validateRequired();
    }

    /**
     * @param GoodEntity $good
     * @return ReceiptGoodRequestEntity
     */
    public function setGood(GoodEntity $good): ReceiptGoodRequestEntity
    {
        $this->good = $good;
        return $this;
    }

    /**
     * @param string $good_id
     * @return ReceiptGoodRequestEntity
     */
    public function setGoodId(string $good_id): ReceiptGoodRequestEntity
    {
        $this->good_id = $good_id;
        return $this;
    }

    /**
     * @param int $quantity
     * @return ReceiptGoodRequestEntity
     */
    public function setQuantity(int $quantity): ReceiptGoodRequestEntity
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @param bool $is_return
     * @return ReceiptGoodRequestEntity
     */
    public function setIsReturn(bool $is_return): ReceiptGoodRequestEntity
    {
        $this->is_return = $is_return;
        return $this;
    }

    /**
     * @param Collection $discounts
     * @return ReceiptGoodRequestEntity
     */
    public function setDiscounts(Collection $discounts): ReceiptGoodRequestEntity
    {
        $this->discounts = $discounts;
        return $this;
    }
}
