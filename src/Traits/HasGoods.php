<?php

namespace TDevAgency\CheckboxUa\Traits;

use Exception;
use Illuminate\Support\Collection;
use TDevAgency\CheckboxUa\Entities\Responses\ReceiptGoodResponseEntity;

trait HasGoods
{
    /**
     * @param array|null $goods
     * @return $this
     * @throws Exception
     */
    protected function setGoods(?array $goods = []): self
    {
        $collection = new Collection();
        if (!empty($goods)) {
            foreach ($goods as $good) {
                $collection->push(new ReceiptGoodResponseEntity($good));
            }
        }
        $this->goods = $collection;
        return $this;
    }
}
