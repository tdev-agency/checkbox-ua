<?php

namespace TDevAgency\CheckboxUa\Groups;

use Exception;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use JsonException;
use TDevAgency\CheckboxUa\Entities\Requests\ShiftCloseRequestEntity;
use TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity;
use TDevAgency\CheckboxUa\Entities\Responses\ShiftResponseEntity;
use TDevAgency\CheckboxUa\Interfaces\GroupInterface;
use TDevAgency\CheckboxUa\Traits\Groupable;

class Shifts implements GroupInterface
{
    use Groupable;

    /**
     * @param array $statuses
     * @param int $limit
     * @param int $offset
     * @param bool $desc
     * @return Collection
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getShifts(
        array $statuses = [],
        int $limit = 25,
        int $offset = 0,
        bool $desc = false
    ): Collection {
        $response = $this->getHttpClient()
            ->request('shifts', 'GET', [
                'query' => compact('statuses', 'limit', 'offset', 'desc')
            ]);
        if (empty($response['results'])) {
            return Collection::make([]);
        }
        $results = [];
        foreach ($response['results'] as $shift) {
            $results[] = new ShiftResponseEntity($shift);
        }

        return Collection::make($results);
    }

    /**
     * @param SignInRequestEntity $signInRequestEntity
     * @param string|null $id
     * @param string|null $fiscal_code
     * @param string|null $fiscal_date
     * @return ShiftResponseEntity
     * @throws GuzzleException
     * @throws JsonException
     */
    public function createShift(
        SignInRequestEntity $signInRequestEntity,
        ?string $id = null,
        ?string $fiscal_code = null,
        ?string $fiscal_date = null
    ): ShiftResponseEntity {
        $result = $this->getHttpClient()
            ->request('shifts', 'POST', [
                'headers' => [
                    'X-License-Key' => $signInRequestEntity->getLicenseKey(),
                ],
                'json' => array_filter(compact('id', 'fiscal_code', 'fiscal_date'))
            ]);
        $entity = new ShiftResponseEntity($result);
        if ($entity->getStatus()->isCreated()) {
            return $this->getShift($entity->getId(), ['delay' => 5000]);
        }
        return $entity;
    }

    /**
     * @param string $id
     * @param array $options
     * @return ShiftResponseEntity
     * @throws GuzzleException
     * @throws JsonException
     * @throws Exception
     */
    public function getShift(string $id, array $options = []): ShiftResponseEntity
    {
        $result = $this->getHttpClient()->request('shifts/'.$id, 'GET', $options);
        return new ShiftResponseEntity($result);
    }

    /**
     * @param ShiftCloseRequestEntity|null $entity
     * @return ShiftResponseEntity
     * @throws GuzzleException
     * @throws JsonException
     * @throws Exception
     */
    public function closeShift(?ShiftCloseRequestEntity $entity = null): ShiftResponseEntity
    {
        if ($entity instanceof Arrayable) {
            $json = array_filter($entity->toArray());
        } else {
            $json = [];
        }

        $result = $this->getHttpClient()
            ->request('shifts/close', 'POST', [
                'json' => $json
            ]);

        return new ShiftResponseEntity($result);
    }
}
