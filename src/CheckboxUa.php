<?php

namespace TDevAgency\CheckboxUa;

use ReflectionClass;
use ReflectionException;
use RuntimeException;
use TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity;
use TDevAgency\CheckboxUa\Tags\Cashier;
use TDevAgency\CheckboxUa\Tags\Organization;
use TDevAgency\CheckboxUa\Tags\Receipts;
use TDevAgency\CheckboxUa\Tags\Shifts;
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
    private Receipts $receipts;
    private string $signInDriver;
    private SignInRequestEntity $signInRequestEntity;

    /**
     * @param string $signInDriver
     * @param SignInRequestEntity $signInRequestEntity
     * @param string|null $accessToken
     * @param bool $isDevMode
     * @throws ReflectionException
     */
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
     * @throws ReflectionException
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

    /**
     * @return Cashier
     * @throws ReflectionException
     */
    public function getCashier(): Cashier
    {
        $group = $this->getGroup(Cashier::class);
        $this->http->setCashier($this->cashier, $this->signInRequestEntity, $this->signInDriver);

        return $group;
    }

    /**
     * @param string $class
     * @return Shifts|Receipts|Organization|Cashier
     * @throws ReflectionException
     */
    private function getGroup(string $class)
    {
        $reflectionClass = new ReflectionClass($class);
        $propertyName = lcfirst($reflectionClass->getShortName());
        if (! class_exists($class)) {
            throw new RuntimeException('Class does not exists '.$class);
        }
        if (! property_exists(self::class, $propertyName)) {
            throw new RuntimeException('Property does not exists '.$propertyName);
        }

        if (! isset($this->$propertyName)) {
            $this->checkImplementsGroupInterface($class);
            /** @var GroupInterface $class */
            $this->$propertyName = $class::create($this->http);
        }

        return $this->$propertyName;
    }

    /**
     * @param string $className
     * @return void
     */
    private function checkImplementsGroupInterface(string $className): void
    {
        try {
            if (! (new ReflectionClass($className))->implementsInterface(GroupInterface::class)
            ) {
                throw new RuntimeException($className.' does not implement interface '.GroupInterface::class);
            }
        } catch (ReflectionException $e) {
            throw new RuntimeException($e);
        }
    }

    /**
     * @param string $class
     * @return GroupInterface
     * @throws ReflectionException
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

        return $this->getGroup($class);
    }

    /**
     * @return Shifts
     * @throws ReflectionException
     */
    public function getShifts(): Shifts
    {
        return $this->getGroup(Shifts::class);
    }

    /**
     * @return Organization
     * @throws ReflectionException
     */
    public function getOrganization(): Organization
    {
        return $this->getGroup(Organization::class);
    }

    /**
     * @return Receipts
     * @throws ReflectionException
     */
    public function getReceipts(): Receipts
    {
        return $this->getGroup(Receipts::class);
    }
}
