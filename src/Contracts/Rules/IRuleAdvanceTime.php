<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules;

use Moves\Eloquent\Verifiable\Contracts\IRule;
use Moves\Eloquent\Verifiable\Rules\Calendar\Enums\AdvanceType;

/**
 * Interface IRuleAdvance
 * @package Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules
 *
 * Rule for enforcing minimum or maximum advance time before the requested appointment.
 */
interface IRuleAdvanceTime extends IRule
{
    public function getAdvanceType(): AdvanceType;

    public function getAdvanceMinutes(): int;
}
