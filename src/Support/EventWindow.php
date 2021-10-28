<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Support;

use DateTimeInterface;

class EventWindow
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
