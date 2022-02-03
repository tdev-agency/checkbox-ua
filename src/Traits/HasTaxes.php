<?php

namespace TDevAgency\CheckboxUa\Traits;

use Exception;
use Illuminate\Support\Collection;
use TDevAgency\CheckboxUa\Entities\Responses\TaxResponseEntity;

trait HasTaxes
{
    /**
     * @param  array|null $taxes
     * @return $this
     * @throws Exception
     */
    protected function setTaxes(?array $taxes = []): self
    {
        $collection = new Collection();
        if (! empty($taxes)) {
            foreach ($taxes as $tax) {
                $collection->push(new TaxResponseEntity($tax));
            }
        }
        $this->taxes = $collection;
        return $this;
    }
}
