<?php

namespace TDevAgency\CheckboxUa\Tests;

use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use TDevAgency\CheckboxUa\CheckboxUa;
use TDevAgency\CheckboxUa\Exceptions\NoOpenShiftException;
use TDevAgency\CheckboxUa\HttpClient;
use TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity;
use TDevAgency\CheckboxUa\Entities\Responses\MeResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\ShiftResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\SignatureResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\SignInResponseEntity;

class CashierTest extends TestCase
{
    public function testInitClient(): CheckboxUa
    {
        $client = new CheckboxUa();
        $this->assertInstanceOf(CheckboxUa::class, $client);

        return $client;
    }

    /**
     * @depends testInitClient
     * @param CheckboxUa $client
     * @return SignInResponseEntity
     * @throws GuzzleException
     * @throws JsonException
     * @throws ReflectionException
     */
    public function testSignIn(CheckboxUa $client): SignInResponseEntity
    {
        $entity = SignInRequestEntity::create(['login' => $_ENV['LOGIN'], 'password' => $_ENV['PASSWORD']]);
        $data = $client->getCashier()->signIn($entity);

        $this->assertInstanceOf(SignInResponseEntity::class, $data);

        return $data;
    }

    /**
     * @depends testInitClient
     * @param CheckboxUa $client
     * @return SignInResponseEntity
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testSignInPinCode(CheckboxUa $client): SignInResponseEntity
    {
        $entity = SignInRequestEntity::create(['license_key' => $_ENV['LICENSE_KEY'], 'pin_code' => $_ENV['PIN_CODE']]);

        $data = $client->getCashier()->signInPinCode($entity);

        $this->assertInstanceOf(SignInResponseEntity::class, $data);

        return $data;
    }


    /**
     * @depends testInitClient
     * @depends testSignIn
     * @param CheckboxUa $client
     * @param SignInResponseEntity $entity
     * @return void
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testMe(CheckboxUa $client, SignInResponseEntity $entity): void
    {
        $res = $client->getCashier()->me();
        $this->assertInstanceOf(MeResponseEntity::class, $res);
    }

    /**
     * @depends testInitClient
     * @depends testSignIn
     * @param CheckboxUa $client
     * @param SignInResponseEntity $entity
     * @return void
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testShift(CheckboxUa $client, SignInResponseEntity $entity): void
    {
        try {
            $res = $client->getCashier()->shift();
            $this->assertInstanceOf(ShiftResponseEntity::class, $res);
        } catch (NoOpenShiftException $exception) {
            $this->assertInstanceOf(NoOpenShiftException::class, $exception);
        }
    }

    /**
     * @depends testInitClient
     * @depends testSignIn
     * @param CheckboxUa $client
     * @param SignInResponseEntity $entity
     * @return void
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testCheckSignature(CheckboxUa $client, SignInResponseEntity $entity): void
    {
        $res = $client->getCashier()->checkSignature();
        $this->assertInstanceOf(SignatureResponseEntity::class, $res);
    }

    /**
     * @depends testInitClient
     * @depends testSignIn
     *
     * @param HttpClient $client
     * @param SignInResponseEntity $signInResponseEntity
     * @return void
     * @throws GuzzleException
     * @throws JsonException
     */
    public function testSignOut(CheckboxUa $client, SignInResponseEntity $signInResponseEntity): void
    {
        $this->assertIsBool($client->getCashier()->signOut());
    }

}
