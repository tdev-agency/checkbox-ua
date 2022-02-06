<?php

namespace TDevAgency\CheckboxUa\Entities\Requests;

use TDevAgency\CheckboxUa\Interfaces\CreateEntityInterface;
use TDevAgency\CheckboxUa\Traits\Arrayable;
use TDevAgency\CheckboxUa\Traits\Createable;

class ReceiptQueryRequestEntity implements CreateEntityInterface
{
    use Arrayable;
    use Createable;

    private ?string $fiscal_code = null;
    private ?string $serial = null;
    private bool $desc = false;
    private int $limit = 25;
    private int $offset = 0;

    /**
     * @param string $fiscal_code
     * @return ReceiptQueryRequestEntity
     */
    public function setFiscalCode(string $fiscal_code): ReceiptQueryRequestEntity
    {
        $this->fiscal_code = $fiscal_code;
        return $this;
    }

    /**
     * @param string $serial
     * @return ReceiptQueryRequestEntity
     */
    public function setSerial(string $serial): ReceiptQueryRequestEntity
    {
        $this->serial = $serial;
        return $this;
    }

    /**
     * @param bool $desc
     * @return ReceiptQueryRequestEntity
     */
    public function setDesc(bool $desc): ReceiptQueryRequestEntity
    {
        $this->desc = $desc;
        return $this;
    }

    /**
     * @param int $limit
     * @return ReceiptQueryRequestEntity
     */
    public function setLimit(int $limit): ReceiptQueryRequestEntity
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @param int $offset
     * @return ReceiptQueryRequestEntity
     */
    public function setOffset(int $offset): ReceiptQueryRequestEntity
    {
        $this->offset = $offset;
        return $this;
    }
}
