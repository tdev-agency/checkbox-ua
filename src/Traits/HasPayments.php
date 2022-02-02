<?php

namespace TDevAgency\CheckboxUa\Traits;

use Illuminate\Support\Collection;
use TDevAgency\CheckboxUa\Entities\Responses\PaymentResponseEntity;

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
