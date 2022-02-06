<?php

namespace TDevAgency\CheckboxUa\Groups;

use Illuminate\Support\Collection;
use TDevAgency\CheckboxUa\Entities\Requests\ReceiptQueryRequestEntity;
use TDevAgency\CheckboxUa\Entities\Requests\ReceiptRequestEntity;
use TDevAgency\CheckboxUa\Entities\Responses\ReceiptResponseEntity;
use TDevAgency\CheckboxUa\Interfaces\GroupInterface;
use TDevAgency\CheckboxUa\Traits\Groupable;

class Receipts implements GroupInterface
{
    use Groupable;


    public function index(ReceiptQueryRequestEntity $requestEntity): Collection
    {
        $data = $this->getHttpClient()->get('receipts', [
            'query' => $requestEntity->toArray()
        ]);

        $collection = [];

        foreach ($data['results'] as $item) {
            $collection[] = new ReceiptResponseEntity($item);
        }

        return Collection::make($collection);
    }

    public function sell(ReceiptRequestEntity $receiptEntity): void
    {
        $res = $this->client->post(
            'receipts/sell',
            [
                'json' => $receiptEntity->toArray()
            ]
        );
        xdebug_break();
    }
}
