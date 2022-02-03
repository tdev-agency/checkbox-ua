<?php

namespace TDevAgency\CheckboxUa;

use ReflectionClass;
use ReflectionException;
use RuntimeException;
use TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity;
use TDevAgency\CheckboxUa\Groups\Cashier;
use TDevAgency\CheckboxUa\Groups\Organization;
use TDevAgency\CheckboxUa\Groups\Shifts;
use TDevAgency\CheckboxUa\HttpClient\HttpClient;
use TDevAgency\CheckboxUa\Interfaces\GroupInterface;

final class CheckboxUa
{

    public const DRIVER_SIGNIN = 'signIn';
    public const DRIVER_SIGNIN_PIN_CODE = 'signInPinCode';
    public const DRIVER_SIGNIN_SIGNATURE = 'signInSignature';

    private ?Cashier $cashier = null;
    private HttpClient $http;
    private ?Shifts $shifts = null;
    private ?Organization $organization = null;
    private string $signInDriver;
    private SignInRequestEntity $signInRequestEntity;

    public function __construct(
        string $signInDriver,
        SignInRequestEntity $signInRequestEntity,
        string $accessToken = null,
        bool $isDevMode = false
    ) {
        $this->http = new HttpClient($isDevMode);
        $this->signInDriver = $signInDriver;
        $this->signInRequestEntity = $signInRequestEntity;
        $this->http->setLicenseKey($signInRequestEntity->getLicenseKey());
        $this->signIn($accessToken);
    }

    /**
     * @param string|null $accessToken
     * @return void
     */
    private function signIn(string $accessToken = null): void
    {
        $cashier = $this->getCashier();
        if (! method_exists($cashier, $this->signInDriver)) {
            throw new RuntimeException('Unsupported sign-in driver: '.$this->signInDriver);
        }

        if ($accessToken === null) {
            $cashier->{$this->signInDriver}($this->signInRequestEntity);
        } else {
            $this->http->setAccessToken($accessToken);
        }
    }

    public function getCashier(): Cashier
    {
        if ($this->cashier === null) {
            $this->checkImplementsGroupInterface(Cashier::class);
            $this->cashier = Cashier::create($this->http);
            $this->http->setCashier($this->cashier, $this->signInRequestEntity, $this->signInDriver);
        }

        return $this->cashier;
    }

    private function checkImplementsGroupInterface($className): void
    {
        try {
            if (! (new ReflectionClass($className))
                ->implementsInterface(GroupInterface::class)) {
                throw new RuntimeException($className.' does not implement interface '.GroupInterface::class);
            }
        } catch (ReflectionException $e) {
            throw new RuntimeException($e);
        }
    }

    /**
     * @param string $class
     * @return GroupInterface
     */
    public function make(string $class): GroupInterface
    {
        if (! class_exists($class)) {
            throw new RuntimeException('Class not exists '.$class);
        }

        $reflectionClass = new ReflectionClass($class);
        $methodName = 'get'.$reflectionClass->getShortName();

        if (! method_exists(self::class, $methodName)) {
            throw new RuntimeException('Method does not exists '.$methodName);
        }

        return $this->{$methodName}();
    }

    public function getShifts(): Shifts
    {
        if ($this->shifts === null) {
            $this->checkImplementsGroupInterface(Shifts::class);
            $this->shifts = Shifts::create($this->http);
        }

        return $this->shifts;
    }

    public function getOrganization(): Organization
    {
        if ($this->organization === null) {
            $this->checkImplementsGroupInterface(Organization::class);
            $this->organization = Organization::create($this->http);
        }
        return $this->organization;
    }
}
