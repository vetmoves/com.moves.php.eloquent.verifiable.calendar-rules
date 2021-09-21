<?php

namespace Tests\Models\Verifiables;

use DateTimeInterface;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableOpenClose;

class TestVerifiableOpenClose implements IVerifiableOpenClose
{
    public function getStartTime(): DateTimeInterface
    {
        return new \DateTime('2021-01-01 09:00:00');
    }

    public function getEndTime(): DateTimeInterface
    {
        return new \DateTime('2021-01-01 10:00:00');
    }
}