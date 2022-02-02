<?php

namespace TDevAgency\CheckboxUa\Entities\Traits;

use Illuminate\Support\Collection;
use TDevAgency\CheckboxUa\Entities\Responses\PaymentResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\TaxResponseEntity;

trait HasPayments
{

    protected function setPayments(?array $payments = []): self
    {
        $collection = new Collection();
        if (! empty($payments)) {
            foreach ($payments as $payment) {
                $collection->push(new PaymentResponseEntity($payment));
            }
        }
        $this->payments = $collection;
        return $this;
    }
}
