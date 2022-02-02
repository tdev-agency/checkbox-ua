<?php

namespace TDevAgency\CheckboxUa\Groups;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use JsonException;
use TDevAgency\CheckboxUa\Entities\Requests\ReportRequestEntity;
use TDevAgency\CheckboxUa\Entities\Responses\ReportResponseEntity;
use TDevAgency\CheckboxUa\Entities\Responses\ShiftResponseEntity;
use TDevAgency\CheckboxUa\Entities\Traits\Group;

class Shifts
{
    use Group;

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
        $response = $this->client->request('shifts', 'GET', [
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
     * @param string $license_key
     * @param string|null $id
     * @param string|null $fiscal_code
     * @param string|null $fiscal_date
     * @return ShiftResponseEntity
     * @throws GuzzleException
     * @throws JsonException
     */
    public function createShift(
        string $license_key,
        ?string $id = null,
        ?string $fiscal_code = null,
        ?string $fiscal_date = null
    ): ShiftResponseEntity {
        $result = $this->client->request('shifts', 'POST', [
            'headers' => [
                'X-License-Key' => $license_key,
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
     */
    public function getShift(string $id, array $options = []): ShiftResponseEntity
    {
        $result = $this->client->request('shifts/'.$id, 'GET', $options);
        return new ShiftResponseEntity($result);
    }

    /**
     * @param bool $skip_client_name_check
     * @param ReportRequestEntity|null $report
     * @param string|null $fiscal_code
     * @param string|null $fiscal_date
     * @return ShiftResponseEntity
     * @throws GuzzleException
     * @throws JsonException
     */
    public function closeShift(
        bool $skip_client_name_check = false,
        ?ReportRequestEntity $report = null,
        ?string $fiscal_code = null,
        ?string $fiscal_date = null
    ): ShiftResponseEntity {
        $result = $this->client->request('shifts/close', 'POST', [
            'json' => array_filter(compact('skip_client_name_check', 'report', 'fiscal_code', 'fiscal_date'))
        ]);
        return new ShiftResponseEntity($result);
    }
}
