<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables;

interface IVerifiableMaxDuration
{
    public function getDurationMinutes(): int;
}