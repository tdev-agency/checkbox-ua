<?php

namespace TDevAgency\CheckboxUa\Entities;

use Illuminate\Support\Collection;
use TDevAgency\CheckboxUa\Interfaces\CreateEntityInterface;
use TDevAgency\CheckboxUa\Traits\Arrayable;
use TDevAgency\CheckboxUa\Traits\Createable;

class GoodEntity implements CreateEntityInterface
{
    use Arrayable;
    use Createable;

    public array $required = [
        'code',
        'name',
        'price'
    ];

    private string $code;
    private string $name;
    private int $price;
    private ?string $barcode = null;
    /** @deprecated */
    private ?string $excise_barcode = null;
    private Collection $excise_barcodes;
    private Collection $tax;
    private ?string $header = null;
    private ?string $footer = null;
    private ?string $uktzed = null;

    public function __construct(array $data = [])
    {
        $this->excise_barcodes = Collection::make();
        $this->tax = Collection::make();
        $this->setData($data)->validateRequired();
    }

    /**
     * @param string $code
     * @return GoodEntity
     */
    public function setCode(string $code): GoodEntity
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @param string $name
     * @return GoodEntity
     */
    public function setName(string $name): GoodEntity
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param int $price
     * @return GoodEntity
     */
    public function setPrice(int $price): GoodEntity
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @param string $barcode
     * @return GoodEntity
     */
    public function setBarcode(string $barcode): GoodEntity
    {
        $this->barcode = $barcode;
        return $this;
    }

    /**
     * @param string $excise_barcode
     * @return GoodEntity
     * @deprecated
     *
     */
    public function setExciseBarcode(string $excise_barcode): GoodEntity
    {
        $this->excise_barcode = $excise_barcode;
        return $this;
    }

    /**
     * @param Collection $excise_barcodes
     * @return GoodEntity
     */
    public function setExciseBarcodes(Collection $excise_barcodes): GoodEntity
    {
        $this->excise_barcodes = $excise_barcodes;
        return $this;
    }

    /**
     * @param Collection $tax
     * @return GoodEntity
     */
    public function setTax(Collection $tax): GoodEntity
    {
        $this->tax = $tax;
        return $this;
    }

    /**
     * @param string $header
     * @return GoodEntity
     */
    public function setHeader(string $header): GoodEntity
    {
        $this->header = $header;
        return $this;
    }

    /**
     * @param string $footer
     * @return GoodEntity
     */
    public function setFooter(string $footer): GoodEntity
    {
        $this->footer = $footer;
        return $this;
    }

    /**
     * @param string $uktzed
     * @return GoodEntity
     */
    public function setUktzed(string $uktzed): GoodEntity
    {
        $this->uktzed = $uktzed;
        return $this;
    }
}
