<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules;

interface IRuleMaxDuration
{
    public function getMaxDurationMinutes(): int;
}