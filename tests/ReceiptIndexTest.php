<?php

namespace TDevAgency\CheckboxUa\Tests;

use PHPUnit\Framework\TestCase;
use TDevAgency\CheckboxUa\CheckboxUa;
use TDevAgency\CheckboxUa\Entities\Requests\ReceiptQueryRequestEntity;
use TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity;
use TDevAgency\CheckboxUa\Groups\Receipts;

class ReceiptIndexTest extends TestCase
{
    public function testIndex()
    {
        $entity = SignInRequestEntity::create([
            'login' => $_ENV['LOGIN'],
            'password' => $_ENV['PASSWORD'],
            'license_key' => $_ENV['LICENSE_KEY'],
        ]);
        $client = new CheckboxUa(CheckboxUa::DRIVER_SIGNIN, $entity);
        $this->assertInstanceOf(CheckboxUa::class, $client);

        $receiptQueryEntity = ReceiptQueryRequestEntity::create();

        $res = $client->make(Receipts::class)->index($receiptQueryEntity);
    }

}
