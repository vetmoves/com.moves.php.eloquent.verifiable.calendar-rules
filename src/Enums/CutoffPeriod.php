<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Enums;

use Konekt\Enum\Enum;

/**
 * Class CutoffPeriod
 * @package Moves\Eloquent\Verifiable\Rules\Calendar\Enums
 *
 * @method static CutoffPeriod DAY()
 * @method static CutoffPeriod WEEK()
 */
class CutoffPeriod extends Enum
{
    const DAY = '1 Day';
    const WEEK = '1 Week';
}
