<?php

namespace Tests\Models\Verifiables;

use DateTimeInterface;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableMaxDuration;

class TestVerifiableMaxDuration implements IVerifiableMaxDuration
{
    /** @var int $duration */
    protected $duration;

    public function __construct(int $duration)
    {
        $this->duration = $duration;
    }

    public function getDurationMinutes(): int
    {
        return $this->duration;
    }
}
