<?php

namespace TDevAgency\CheckboxUa\Interfaces;

interface ReceiptTypeInterface
{
    public const  SELL_TYPE = 'SELL';
    public const  RETURN_TYPE = 'RETURN';
    public const  SERVICE_IN_TYPE = 'SERVICE_IN';
    public const  SERVICE_OUT_TYPE = 'SERVICE_OUT';
    public const  SERVICE_CURRENCY_TYPE = 'SERVICE_CURRENCY';
    public const  CURRENCY_EXCHANGE_TYPE = 'CURRENCY_EXCHANGE';
    public const  PAWNSHOP_TYPE = 'PAWNSHOP';

    public function __toString(): string;
}
