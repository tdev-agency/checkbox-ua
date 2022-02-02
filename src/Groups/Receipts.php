<?php

namespace TDevAgency\CheckboxUa\Groups;

use TDevAgency\CheckboxUa\Client;
use TDevAgency\CheckboxUa\Entities\Requests\ReceiptRequestEntity;

class Receipts
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function create(ReceiptRequestEntity $receiptEntity)
    {
        $res = $this->client->request('receipts/sell', 'POST', [
            'json' => $receiptEntity->toArray()
        ]);

    }

}
