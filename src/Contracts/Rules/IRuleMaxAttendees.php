<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules;

use Moves\Eloquent\Verifiable\Contracts\IRule;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;

interface IRuleMaxAttendees extends IRule
{
    public function getMaxAttendees(?IVerifiableEvent $event = null): int;
}
