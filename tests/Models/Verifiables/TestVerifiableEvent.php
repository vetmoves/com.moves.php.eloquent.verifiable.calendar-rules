<?php

namespace Tests\Models\Verifiables;

use DateTimeInterface;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEventAttendee;

class TestVerifiableEvent implements IVerifiableEvent
{
    /** @var DateTimeInterface $start */
    protected $start;

    /** @var DateTimeInterface $end */
    protected $end;

    /** @var IVerifiableEventAttendee[] $attendees */
    protected $attendees;

    /**
     * TestVerifiableEvent constructor.
     * @param DateTimeInterface $start
     * @param DateTimeInterface $end
     * @param IVerifiableEventAttendee[] $attendees
     */
    public function __construct(DateTimeInterface $start, DateTimeInterface $end, array $attendees = [])
    {
        $this->start = $start;
        $this->end = $end;
        $this->attendees = $attendees;
    }

    public function getStartTime(): DateTimeInterface
    {
        return $this->start;
    }

    public function getEndTime(): DateTimeInterface
    {
        return $this->end;
    }

    /**
     * @return IVerifiableEventAttendee[]
     */
    public function getAttendees(): array
    {
        return $this->attendees;
    }
}
