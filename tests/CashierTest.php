<?php

namespace TDevAgency\CheckboxUa\Tests;

use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use PHPUnit\Framework\TestCase;
use TDevAgency\CheckboxUa\Client;
use TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity;
use TDevAgency\CheckboxUa\Entities\Responses\MeResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\ShiftResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\SignatureResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\SignInResponseEntity;

class CashierTest extends TestCase
{
    public function testInitClient()
    {
        $client = new Client();
        $this->assertInstanceOf(Client::class, $client);

        return $client;
    }

    /**
     * @depends testInitClient
     * @param Client $client
     * @return SignInResponseEntity
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testSignIn(Client $client): SignInResponseEntity
    {
        $entity = SignInRequestEntity::create(['login' => $_ENV['LOGIN'], 'password' => $_ENV['password']]);
        $data = $client->cashier->signIn($entity);

        $this->assertInstanceOf(SignInResponseEntity::class, $data);

        return $data;
    }

    /**
     * @depends testInitClient
     * @param Client $client
     * @return SignInResponseEntity
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testSignInPinCode(Client $client): SignInResponseEntity
    {
        $entity = SignInRequestEntity::create(['licence_key' => $_ENV['LICENSE_KEY'], 'pin_code' => $_ENV['PIN_CODE']]);

        $data = $client->cashier->signInPinCode($entity);

        $this->assertInstanceOf(SignInResponseEntity::class, $data);

        return $data;
    }


    /**
     * @depends testInitClient
     * @depends testSignIn
     * @param Client $client
     * @param SignInResponseEntity $entity
     * @return void
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testMe(Client $client, SignInResponseEntity $entity): void
    {
        $res = $client->cashier->me();
        $this->assertInstanceOf(MeResponseEntity::class, $res);
    }

    /**
     * @depends testInitClient
     * @depends testSignIn
     * @param Client $client
     * @param SignInResponseEntity $entity
     * @return void
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testShift(Client $client, SignInResponseEntity $entity): void
    {
        $res = $client->cashier->shift();
        $this->assertInstanceOf(ShiftResponseEntity::class, $res);
    }

    /**
     * @depends testInitClient
     * @depends testSignIn
     * @param Client $client
     * @param SignInResponseEntity $entity
     * @return void
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testCheckSignature(Client $client, SignInResponseEntity $entity): void
    {
        $res = $client->cashier->checkSignature();
        $this->assertInstanceOf(SignatureResponseEntity::class, $res);
    }

    /**
     * @depends testInitClient
     * @depends testSignIn
     *
     * @param Client $client
     * @param SignInResponseEntity $signInResponseEntity
     * @return void
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testSignOut(Client $client, SignInResponseEntity $signInResponseEntity): void
    {
        $this->assertIsBool($client->cashier->signOut());
    }

}
