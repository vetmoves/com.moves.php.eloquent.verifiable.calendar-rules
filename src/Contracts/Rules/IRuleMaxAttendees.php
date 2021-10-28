<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules;

use Moves\Eloquent\Verifiable\Contracts\IRule;

interface IRuleMaxAttendees extends IRule
{
    public function getMaxAttendees(): int;
}
