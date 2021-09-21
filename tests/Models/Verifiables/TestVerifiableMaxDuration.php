<?php

namespace Tests\Models\Verifiables;

use DateTimeInterface;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableMaxDuration;

class TestVerifiableMaxDuration implements IVerifiableMaxDuration
{
    public function getDurationMinutes(): int
    {
        return 90;
    }
}