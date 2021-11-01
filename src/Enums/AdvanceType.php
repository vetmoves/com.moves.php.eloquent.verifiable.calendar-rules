<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Enums;

use Konekt\Enum\Enum;

/**
 * Class CutoffPeriod
 * @package Moves\Eloquent\Verifiable\Rules\Calendar\Enums
 *
 * @method static AdvanceType MIN()
 * @method static AdvanceType MAX()
 */
class AdvanceType extends Enum
{
    const MIN = 'Minimum';
    const MAX = 'Maximum';
}
