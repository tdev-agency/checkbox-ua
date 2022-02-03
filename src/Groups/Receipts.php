<?php

namespace TDevAgency\CheckboxUa\Groups;

use TDevAgency\CheckboxUa\HttpClient;
use TDevAgency\CheckboxUa\Entities\Requests\ReceiptRequestEntity;

class Receipts
{
    private HttpClient $client;

    public function __construct(HttpClient $client)
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
