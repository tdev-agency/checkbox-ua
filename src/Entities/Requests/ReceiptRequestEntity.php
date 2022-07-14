<?php

namespace TDevAgency\CheckboxUa\Entities\Requests;

use Illuminate\Support\Collection;
use TDevAgency\CheckboxUa\Interfaces\CreateEntityInterface;
use TDevAgency\CheckboxUa\Traits\Arrayable;
use TDevAgency\CheckboxUa\Traits\Createable;

class ReceiptRequestEntity implements CreateEntityInterface
{
    use Arrayable;
    use Createable;

    public array $required = [
        'goods'
    ];
    private ?string $id = null;
    private ?string $cashier_name = null;
    private ?string $departament = null;
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

    public function __construct(array $data = [])
    {
        $this->discounts = new Collection();
        $this->payments = new Collection();
        if (!empty($data)) {
            $this->setData($data)->validateRequired();
        }
    }

    /**
     * @param string $id
     * @return ReceiptRequestEntity
     */
    public function setId(string $id): ReceiptRequestEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $cashier_name
     * @return ReceiptRequestEntity
     */
    public function setCashierName(string $cashier_name): ReceiptRequestEntity
    {
        $this->cashier_name = $cashier_name;
        return $this;
    }

    /**
     * @param string $departament
     * @return ReceiptRequestEntity
     */
    public function setDepartament(string $departament): ReceiptRequestEntity
    {
        $this->departament = $departament;
        return $this;
    }

    /**
     * @param Collection $goods
     * @return ReceiptRequestEntity
     */
    public function setGoods(Collection $goods): ReceiptRequestEntity
    {
        $this->goods = $goods;
        return $this;
    }

    /**
     * @param string $delivery
     * @return ReceiptRequestEntity
     */
    public function setDelivery(string $delivery): ReceiptRequestEntity
    {
        $this->delivery = $delivery;
        return $this;
    }

    /**
     * @param Collection $discounts
     * @return ReceiptRequestEntity
     */
    public function setDiscounts(Collection $discounts): ReceiptRequestEntity
    {
        $this->discounts = $discounts;
        return $this;
    }

    /**
     * @param Collection $payments
     * @return ReceiptRequestEntity
     */
    public function setPayments(Collection $payments): ReceiptRequestEntity
    {
        $this->payments = $payments;
        return $this;
    }

    /**
     * @param bool $rounding
     * @return ReceiptRequestEntity
     */
    public function setRounding(bool $rounding): ReceiptRequestEntity
    {
        $this->rounding = $rounding;
        return $this;
    }

    /**
     * @param string $header
     * @return ReceiptRequestEntity
     */
    public function setHeader(string $header): ReceiptRequestEntity
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @param string $footer
     * @return ReceiptRequestEntity
     */
    public function setFooter(string $footer): ReceiptRequestEntity
    {
        $this->footer = $footer;
        return $this;
    }

    /**
     * @param string $barcode
     * @return ReceiptRequestEntity
     */
    public function setBarcode(string $barcode): ReceiptRequestEntity
    {
        $this->barcode = $barcode;
        return $this;
    }

    /**
     * @param string $order_id
     * @return ReceiptRequestEntity
     */
    public function setOrderId(string $order_id): ReceiptRequestEntity
    {
        $this->order_id = $order_id;
        return $this;
    }

    /**
     * @param string $related_receipt_id
     * @return ReceiptRequestEntity
     */
    public function setRelatedReceiptId(string $related_receipt_id): ReceiptRequestEntity
    {
        $this->related_receipt_id = $related_receipt_id;
        return $this;
    }

    /**
     * @param string $previous_receipt_id
     * @return ReceiptRequestEntity
     */
    public function setPreviousReceiptId(string $previous_receipt_id): ReceiptRequestEntity
    {
        $this->previous_receipt_id = $previous_receipt_id;
        return $this;
    }

    /**
     * @param bool $technical_return
     * @return ReceiptRequestEntity
     */
    public function setTechnicalReturn(bool $technical_return): ReceiptRequestEntity
    {
        $this->technical_return = $technical_return;
        return $this;
    }

    /**
     * @param array $context
     * @return ReceiptRequestEntity
     */
    public function setContext(array $context): ReceiptRequestEntity
    {
        $this->context = $context;
        return $this;
    }

    /**
     * @param bool $is_pawnshop
     * @return ReceiptRequestEntity
     */
    public function setIsPawnshop(bool $is_pawnshop): ReceiptRequestEntity
    {
        $this->is_pawnshop = $is_pawnshop;
        return $this;
    }
}
