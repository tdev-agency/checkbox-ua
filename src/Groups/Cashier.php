<?php

namespace TDevAgency\CheckboxUa\Groups;


use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use RuntimeException;
use TDevAgency\CheckboxUa\Client;
use TDevAgency\CheckboxUa\Entities\Responses\MeResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\ShiftResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\SignatureResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\SignInResponseEntity;

class Cashier
{

    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function me(): MeResponseEntity
    {
        $data = $this->client->request('cashier/me');

        return new MeResponseEntity($data);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function shift(): ShiftResponseEntity
    {
        $data = $this->client->request('cashier/shift');

        if ($data === null) {
            throw new RuntimeException('Cashier.shift: Cashier shift is not opened');
        }

        return new ShiftResponseEntity($data);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function checkSignature(): SignatureResponseEntity
    {
        $data = $this->client->request('cashier/check-signature');

        return new SignatureResponseEntity($data);
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function signIn(string $login, string $password): SignInResponseEntity
    {
        $data = $this->client->request('cashier/signin', 'POST', [
            'json' => [
                'login' => $login,
                'password' => $password,
            ]
        ]);

        $entity = new SignInResponseEntity($data);

        $this->client->setAccessToken($entity);

        return $entity;
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function signOut(): bool
    {
        $this->client->request('cashier/signout', 'POST');

        return true;
    }

    /**
     * @throws GuzzleException
     * @throws JsonException
     */
    public function signInPinCode(string $licenseKey, string $pinCode): SignInResponseEntity
    {
        $data = $this->client->request('cashier/signinPinCode', 'POST', [
            'headers' => [
                'X-License-Key' => $licenseKey
            ],
            'json' => [
                'pin_code' => $pinCode,
            ]
        ]);

        $entity = new SignInResponseEntity($data);

        $this->client->setAccessToken($entity);

        return $entity;
    }
}
