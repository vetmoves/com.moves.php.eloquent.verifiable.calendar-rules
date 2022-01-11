<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules;

use Moves\Eloquent\Verifiable\Contracts\IRule;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;

interface IRuleMaxDuration extends IRule
{
    public function getMaxDurationMinutes(IVerifiableEvent $event): int;
}
