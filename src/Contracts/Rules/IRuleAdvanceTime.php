<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules;

use Moves\Eloquent\Verifiable\Contracts\IRule;

/**
 * Interface IRuleAdvance
 * @package Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules
 *
 * Rule for enforcing minimum or maximum advance before the requested appointment.
 *
 * Negative advance minutes implies a maximum requirement.
 * i.e. Actual advance time must be "less than" (ie negative) or equal to the configured advance requirement.
 * e.g -60 advance minutes means events cannot be booked more than 60 minutes in advance.
 *
 * Positive advance minutes implies a minimum requirement.
 * i.e. Actual advance time must be "greater than' (ie positive) or equal to the configured advance requirement.
 * e.g 60 advance minutes means events must be booked at least 60 minutes in advance.
 */
interface IRuleAdvanceTime extends IRule
{
    public function getAdvanceMinutes(): int;
}
