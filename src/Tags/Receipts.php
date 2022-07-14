<?php

namespace TDevAgency\CheckboxUa\Tags;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Collection;
use TDevAgency\CheckboxUa\Entities\Requests\ReceiptQueryRequestEntity;
use TDevAgency\CheckboxUa\Entities\Requests\ReceiptRequestEntity;
use TDevAgency\CheckboxUa\Entities\Responses\ReceiptResponseEntity;
use TDevAgency\CheckboxUa\Exceptions\NoOpenShiftException;
use TDevAgency\CheckboxUa\Exceptions\PropertyValidationException;
use TDevAgency\CheckboxUa\Interfaces\GroupInterface;
use TDevAgency\CheckboxUa\Traits\Groupable;
use Throwable;

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

    /**
     * @throws NoOpenShiftException
     * @throws PropertyValidationException
     * @throws Throwable
     */
    public function sell(ReceiptRequestEntity $receiptEntity): ReceiptResponseEntity
    {
        try {
            $res = $this->getHttpClient()->post(
                'receipts/sell',
                [
                    'json' => $receiptEntity->toArray()
                ]
            );
        } catch (ClientException $exception) {
            if ($exception->getCode() === 400) {
                throw new NoOpenShiftException($exception->getMessage());
            }
            throw $exception;
        }
        return new ReceiptResponseEntity($res);
    }
}
