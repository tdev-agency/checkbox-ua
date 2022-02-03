<?php

namespace TDevAgency\CheckboxUa\Groups;

use TDevAgency\CheckboxUa\Entities\Requests\ReceiptRequestEntity;
use TDevAgency\CheckboxUa\HttpClient\HttpClient;
use TDevAgency\CheckboxUa\Interfaces\GroupInterface;
use TDevAgency\CheckboxUa\Traits\Groupable;

class Receipts implements GroupInterface
{
    use Groupable;

    public function sell(ReceiptRequestEntity $receiptEntity): void
    {
        $res = $this->client->post('receipts/sell', [
            'json' => $receiptEntity->toArray()
        ]);
    }

}
