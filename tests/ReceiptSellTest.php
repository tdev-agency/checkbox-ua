<?php

namespace TDevAgency\CheckboxUa\Tests;

use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use TDevAgency\CheckboxUa\CheckboxUa;
use TDevAgency\CheckboxUa\Entities\Requests\ReceiptRequestEntity;
use TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity;
use TDevAgency\CheckboxUa\Tags\Receipts;
use TDevAgency\CheckboxUa\Helpers\ShiftHelper;

class ReceiptSellTest extends TestCase
{
    public function testSell()
    {
        $entity = SignInRequestEntity::create([
            'login' => $_ENV['LOGIN'],
            'password' => $_ENV['PASSWORD'],
            'license_key' => $_ENV['LICENSE_KEY'],
        ]);
        $client = new CheckboxUa(CheckboxUa::DRIVER_SIGNIN, $entity);
        $this->assertInstanceOf(CheckboxUa::class, $client);

        $receiptRequestEntity = new ReceiptRequestEntity();

        $goodsCollection = Collection::make();

        $receiptRequestEntity->setGoods($goodsCollection);

        $openedShift = (new ShiftHelper($client->getShifts()))->getOpenedOrCreateShift();

        $res = $client->make(Receipts::class)->sell($receiptRequestEntity);
    }
}
