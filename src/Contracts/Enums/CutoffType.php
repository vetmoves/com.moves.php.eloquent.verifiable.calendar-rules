<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Enums;

use Konekt\Enum\Enum;

/**
 * Class CutoffType
 * @package Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Enums
 *
 * @method static CutoffType ALLOW()
 * @method static CutoffType DISALLOW()
 */
class CutoffType extends Enum
{
    const ALLOW = 'ALLOW';
    const DISALLOW = 'DISALLOW';
}
