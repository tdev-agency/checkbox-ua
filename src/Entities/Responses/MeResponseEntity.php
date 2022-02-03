<?php

namespace TDevAgency\CheckboxUa\Entities\Responses;

use DateTimeInterface;
use Illuminate\Contracts\Support\Arrayable;
use TDevAgency\CheckboxUa\Traits\ResponseEntity;

class MeResponseEntity implements Arrayable
{
    use ResponseEntity;

    private string $id;
    private string $full_name;
    private string $nin;
    private string $key_id;
    private array $permissions = [];
    private ?string $blocked = null;
    private DateTimeInterface $created_at;
    private ?DateTimeInterface $updated_at = null;
    private ?DateTimeInterface $certificate_end = null;
    private OrganizationResponseEntity $organization;

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
    public function getFullName(): string
    {
        return $this->full_name;
    }

    /**
     * @return string
     */
    public function getNin(): string
    {
        return $this->nin;
    }

    /**
     * @return string
     */
    public function getKeyId(): string
    {
        return $this->key_id;
    }

    /**
     * @return array
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * @return string|null
     */
    public function getBlocked(): ?string
    {
        return $this->blocked;
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
    public function getCertificateEnd(): ?DateTimeInterface
    {
        return $this->certificate_end;
    }

    /**
     * @return OrganizationResponseEntity
     */
    public function getOrganization(): OrganizationResponseEntity
    {
        return $this->organization;
    }
}
