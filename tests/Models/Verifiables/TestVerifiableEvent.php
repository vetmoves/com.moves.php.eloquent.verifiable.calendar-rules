<?php

namespace Tests\Models\Verifiables;

use DateTimeInterface;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;

class TestVerifiableEvent implements IVerifiableEvent
{
    /** @var DateTimeInterface $start */
    protected $start;

    /** @var DateTimeInterface $end */
    protected $end;

    public function __construct(DateTimeInterface $start, DateTimeInterface $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function getStartTime(): DateTimeInterface
    {
        return $this->start;
    }

    public function getEndTime(): DateTimeInterface
    {
        return $this->end;
    }
}
