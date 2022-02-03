<?php

namespace TDevAgency\CheckboxUa\Entities\Requests;

use TDevAgency\CheckboxUa\Interfaces\CreateEntityInterface;
use TDevAgency\CheckboxUa\Traits\Createable;

class SignInRequestEntity implements CreateEntityInterface
{
    use Createable;

    protected array $required = [
        'license_key',
    ];

    private string $login;
    private string $password;
    private string $license_key;
    private string $pin_code;

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     * @return SignInRequestEntity
     */
    public function setLogin(string $login): SignInRequestEntity
    {
        $this->login = $login;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return SignInRequestEntity
     */
    public function setPassword(string $password): SignInRequestEntity
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getLicenseKey(): string
    {
        return $this->license_key;
    }

    /**
     * @param string $license_key
     * @return SignInRequestEntity
     */
    public function setLicenseKey(string $license_key): SignInRequestEntity
    {
        $this->license_key = $license_key;
        return $this;
    }

    /**
     * @return string
     */
    public function getPinCode(): string
    {
        return $this->pin_code;
    }

    /**
     * @param string $pin_code
     * @return SignInRequestEntity
     */
    public function setPinCode(string $pin_code): SignInRequestEntity
    {
        $this->pin_code = $pin_code;
        return $this;
    }
}
