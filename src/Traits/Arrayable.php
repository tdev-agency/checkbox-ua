<?php

namespace TDevAgency\CheckboxUa\Traits;

use DateTimeInterface;
use ReflectionClass;
use ReflectionProperty;
use TDevAgency\CheckboxUa\Interfaces\ShiftStatusInterface;
use Illuminate\Contracts\Support\Arrayable as ArrayableInterface;

trait Arrayable
{
    /** @return array */
    public function toArray(): array
    {
        $reflect = new ReflectionClass(self::class);
        $props = $reflect->getProperties(ReflectionProperty::IS_PRIVATE);
        $data = [];
        foreach ($props as $prop) {
            $prop = $prop->getName();
            if ($this->$prop === null) {
                continue;
            }
            if ($this->$prop instanceof ArrayableInterface) {
                $data[$prop] = $this->$prop->toArray();
            } elseif ($this->$prop instanceof DateTimeInterface) {
                $data[$prop] = $this->$prop->format('c');
            } elseif ($this->$prop instanceof ShiftStatusInterface) {
                $data[$prop] = $this->$prop->__toString();
            } else {
                $data[$prop] = $this->$prop;
            }
        }

        return $data;
    }
}
