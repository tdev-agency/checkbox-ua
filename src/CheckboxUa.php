<?php

namespace TDevAgency\CheckboxUa;

use ReflectionClass;
use ReflectionException;
use RuntimeException;
use TDevAgency\CheckboxUa\Groups\Cashier;
use TDevAgency\CheckboxUa\Groups\Shifts;
use TDevAgency\CheckboxUa\Interfaces\GroupInterface;

final class CheckboxUa
{
    private ?Cashier $cashier = null;
    private HttpClient $http;
    private ?Shifts $shifts = null;

    public function __construct(bool $isDevMode = false)
    {
        $this->http = new HttpClient($isDevMode);
    }

    /**
     * @param string $class
     * @return GroupInterface
     * @deprecated
     */
    public function make(string $class): GroupInterface
    {
        if (! class_exists($class)) {
            throw new RuntimeException('Class not exists '.$class);
        }
        $this->checkImplementsGroupInterface($class);

        return $class::create($this->http);
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

    public function getCashier(): ?Cashier
    {
        if ($this->cashier === null) {
            $this->checkImplementsGroupInterface(Cashier::class);
            $this->cashier = Cashier::create($this->http);
        }

        return $this->cashier;
    }

    public function getShifts(): Shifts
    {
        if ($this->shifts === null) {
            $this->checkImplementsGroupInterface(Shifts::class);
            $this->shifts = Shifts::create($this->http);
        }

        return $this->shifts;
    }
}


