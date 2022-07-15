<?php

namespace TDevAgency\CheckboxUa\Helpers;

use TDevAgency\CheckboxUa\Entities\Responses\ShiftResponseEntity;
use TDevAgency\CheckboxUa\Tags\Shifts;
use TDevAgency\CheckboxUa\Interfaces\ShiftStatusInterface;
use Throwable;

class ShiftHelper
{
    private Shifts $shiftsGroup;

    public function __construct(Shifts $shiftsGroup)
    {
        $this->shiftsGroup = $shiftsGroup;
    }

    /**
     * @return ShiftResponseEntity
     * @throws Throwable
     */
    public function getOpenedOrCreateShift(): ShiftResponseEntity
    {
        $openedShifts = $this->shiftsGroup->getShifts([ShiftStatusInterface::OPENED], 25, 0, true)
            ->filter(function (ShiftResponseEntity $shiftResponseEntity) {
                return $shiftResponseEntity->getStatus()->isOpened();
            });

        if ($openedShifts->isEmpty()) {
            return $this->shiftsGroup->createShift();
        }

        return $openedShifts->first();
    }
}
