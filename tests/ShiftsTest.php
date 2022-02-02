<?php

namespace TDevAgency\CheckboxUa\Tests;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use JsonException;
use PHPUnit\Framework\TestCase;
use TDevAgency\CheckboxUa\Client;
use TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity;
use TDevAgency\CheckboxUa\Entities\Responses\MeResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\ShiftResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\SignatureResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\SignInResponseEntity;
use TDevAgency\CheckboxUa\Groups\Shifts;

class ShiftsTest extends TestCase
{
    public function testAuthorizeClient()
    {
        $client = new Client();
        $this->assertInstanceOf(Client::class, $client);
        $entity = SignInRequestEntity::create(['login' => $_ENV['LOGIN'], 'password' => $_ENV['password']]);
        $client->cashier->signIn($entity);
        return $client->shifts;
    }

    /**
     * @depends testAuthorizeClient
     * @param Shifts $shifts
     * @return void
     */
    public function testCloseShift(Shifts $shifts): void
    {
        $result = $shifts->closeShift();
        $this->assertInstanceOf(ShiftResponseEntity::class, $result);
    }

    /**
     * @depends testAuthorizeClient
     * @param Shifts $shifts
     * @return void
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testCreateShift(Shifts $shifts): void
    {
        $result = $shifts->createShift($_ENV['LICENSE_KEY']);
        $this->assertInstanceOf(ShiftResponseEntity::class, $result);
    }


    /**
     * @depends testAuthorizeClient
     * @param Shifts $shifts
     * @return void
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testGetShifts(Shifts $shifts)
    {
        $result = $shifts->getShifts();
        $this->assertInstanceOf(Collection::class, $result);
    }
}
