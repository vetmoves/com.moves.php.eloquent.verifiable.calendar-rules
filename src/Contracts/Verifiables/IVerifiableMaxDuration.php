<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables;

use Moves\Eloquent\Verifiable\Contracts\IVerifiable;

interface IVerifiableMaxDuration extends IVerifiable
{
    public function getDurationMinutes(): int;
}
