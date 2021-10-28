<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules;

use Moves\Eloquent\Verifiable\Contracts\IRule;

interface IRuleMaxDuration extends IRule
{
    public function getMaxDurationMinutes(): int;
}
