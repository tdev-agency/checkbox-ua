<?php

namespace TDevAgency\CheckboxUa;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use RuntimeException;
use TDevAgency\CheckboxUa\Entities\Responses\SignInResponseEntity;
use TDevAgency\CheckboxUa\Groups\Cashier;
use TDevAgency\CheckboxUa\Groups\Receipts;
use TDevAgency\CheckboxUa\Groups\Shifts;

class Client
{

    private const LIVE_API = 'https://api.checkbox.ua/api/v1/';

    private const DEV_API = 'https://dev-api.checkbox.in.ua/api/v1/';

    public Cashier $cashier;
    public Receipts $receipts;
    public Shifts $shifts;
    private GuzzleHttpClient $http;
    private array $options = [];

    public function __construct(bool $isDevMode = false)
    {
        $this->http = new GuzzleHttpClient([
            'base_uri' => ! $isDevMode ? self::LIVE_API : self::DEV_API,
        ]);
        $this->cashier = new Cashier($this);
        $this->receipts = new Receipts($this);
        $this->shifts = new Shifts($this);
    }

    /**
     * @param $uri
     * @param string $method
     * @param array $options
     * @return mixed
     * @throws GuzzleException
     * @throws JsonException
     */
    public function request($uri, string $method = 'GET', array $options = [])
    {
        $options = array_merge_recursive($this->options, $options);

        $contents = $this->http->request($method, $uri, $options)->getBody()->getContents();

        if ($contents === '') {
            throw new RuntimeException(
                'Empty response'
            );
        }

        $decodedContents = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException(
                'Error trying to decode response: '.
                json_last_error_msg()
            );
        }

        return $decodedContents;
    }

    public function setAccessToken(SignInResponseEntity $entity): Client
    {
        $this->options = [
            'headers' => [
                'Authorization' => $entity->getTokenType().' '.$entity->getAccessToken(),
            ]
        ];

        return $this;
    }
}


