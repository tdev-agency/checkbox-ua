<?php

namespace TDevAgency\CheckboxUa;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use RuntimeException;
use TDevAgency\CheckboxUa\Entities\Responses\SignInResponseEntity;
use TDevAgency\CheckboxUa\Exceptions\ForbiddenException;

final class HttpClient
{

    private const LIVE_API = 'https://api.checkbox.ua/api/v1/';

    private const DEV_API = 'https://dev-api.checkbox.in.ua/api/v1/';

    private GuzzleHttpClient $http;
    private array $options = [];

    public function __construct(bool $isDevMode = false)
    {
        $this->http = new GuzzleHttpClient([
            'base_uri' => ! $isDevMode ? self::LIVE_API : self::DEV_API,
        ]);
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

        try {
            $contents = $this->http->request($method, $uri, $options)->getBody()->getContents();
        } catch (ClientException $clientException) {
            $this->proceedException($clientException);
        }

        return $this->getJson($contents);
    }

    private function proceedException(ClientException $exception): void
    {
        $contents = $exception->getResponse()->getBody()->getContents();

        if ($exception->getCode() === 403) {
            throw new ForbiddenException($contents);
        }
        if ($exception->getCode() === 401) {
            throw new Exceptions\UnauthorizedException($contents);
        }
        if ($exception->getCode() === 422) {
            throw new Exceptions\UnprocessableEntityException($contents);
        }

        throw $exception;
    }

    private function getJson(string $contents): array
    {
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

    /**
     * @param SignInResponseEntity $entity
     * @return $this
     */
    public function setAccessToken(SignInResponseEntity $entity): HttpClient
    {
        $this->options = [
            'headers' => [
                'Authorization' => $entity->getTokenType().' '.$entity->getAccessToken(),
            ]
        ];

        return $this;
    }
}


