<?php

namespace TDevAgency\CheckboxUa\Entities\Responses;

use DateTimeInterface;
use Illuminate\Contracts\Support\Arrayable;
use TDevAgency\CheckboxUa\Entities\Traits\ResponseEntity;

class OrganizationResponseEntity implements Arrayable
{
    use ResponseEntity;

    private string $id;
    private string $title;
    private string $edrpou;
    private string $tax_number;
    private DateTimeInterface $created_at;
    private ?DateTimeInterface $updated_at = null;
    private ?DateTimeInterface $subscription_exp = null;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getEdrpou(): string
    {
        return $this->edrpou;
    }

    /**
     * @return string
     */
    public function getTaxNumber(): string
    {
        return $this->tax_number;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->created_at;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updated_at;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getSubscriptionExp(): ?DateTimeInterface
    {
        return $this->subscription_exp;
    }

}
