<?php

namespace TDevAgency\CheckboxUa\Entities\Traits;

use DateTimeInterface;
use Illuminate\Contracts\Support\Arrayable;
use ReflectionClass;
use ReflectionProperty;
use TDevAgency\CheckboxUa\Entities\Interfaces\RequestEntityInterface;

trait RequestEntity
{

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
            if ($this->$prop instanceof Arrayable) {
                $data[$prop] = $this->$prop->toArray();
            } elseif ($this->$prop instanceof DateTimeInterface) {
                $data[$prop] = $this->$prop->format('c');
            } else {
                $data[$prop] = $this->$prop;
            }
        }

        return $data;
    }

}
