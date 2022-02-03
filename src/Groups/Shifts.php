<?php

namespace TDevAgency\CheckboxUa\Groups;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use TDevAgency\CheckboxUa\Entities\Requests\ShiftCloseRequestEntity;
use TDevAgency\CheckboxUa\Entities\Requests\SignInRequestEntity;
use TDevAgency\CheckboxUa\Entities\Responses\ShiftResponseEntity;
use TDevAgency\CheckboxUa\Exceptions\NoOpenShiftException;
use TDevAgency\CheckboxUa\Exceptions\OpenedShiftException;
use TDevAgency\CheckboxUa\Interfaces\GroupInterface;
use TDevAgency\CheckboxUa\Traits\Groupable;
use Throwable;

class Shifts implements GroupInterface
{
    use Groupable;

    /**
     * @param array $statuses
     * @param int $limit
     * @param int $offset
     * @param bool $desc
     * @return Collection
     * @throws Throwable
     */
    public function getShifts(
        array $statuses = [],
        int $limit = 25,
        int $offset = 0,
        bool $desc = false
    ): Collection {
        $response = $this->getHttpClient()
            ->get('shifts', [
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
     * @param string|null $id
     * @param string|null $fiscal_code
     * @param string|null $fiscal_date
     * @return ShiftResponseEntity
     * @throws Throwable
     */
    public function createShift(
        ?string $id = null,
        ?string $fiscal_code = null,
        ?string $fiscal_date = null
    ): ShiftResponseEntity {
        try {
            $result = $this->getHttpClient()
                ->post('shifts', [
                    'json' => array_filter(compact('id', 'fiscal_code', 'fiscal_date'))
                ]);
            $entity = new ShiftResponseEntity($result);
            if ($entity->getStatus()->isCreated()) {
                return $this->getShift($entity->getId(), ['delay' => 5000]);
            }
            return $entity;
        } catch (ClientException $exception) {
            if ($exception->getCode() === 400) {
                throw new OpenedShiftException($exception->getMessage());
            }
            throw $exception;
        }
    }

    /**
     * @param string $id
     * @param array $options
     * @return ShiftResponseEntity
     * @throws Throwable
     */
    public function getShift(string $id, array $options = []): ShiftResponseEntity
    {
        $result = $this->getHttpClient()->get('shifts/'.$id, $options);
        return new ShiftResponseEntity($result);
    }

    /**
     * @param ShiftCloseRequestEntity|null $entity
     * @return ShiftResponseEntity
     * @throws Throwable
     */
    public function closeShift(?ShiftCloseRequestEntity $entity = null): ShiftResponseEntity
    {
        if ($entity instanceof Arrayable) {
            $json = array_filter($entity->toArray());
        } else {
            $json = [];
        }

        try {
            $result = $this->getHttpClient()
                ->post('shifts/close', [
                    'json' => $json
                ]);
        } catch (ClientException $exception) {
            if ($exception->getCode() === 400) {
                throw new NoOpenShiftException($exception->getMessage());
            }
            throw $exception;
        }
        return new ShiftResponseEntity($result);
    }
}
