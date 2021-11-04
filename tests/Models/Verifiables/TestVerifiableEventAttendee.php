<?php

namespace Tests\Models\Verifiables;

use DateTimeInterface;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEventAttendee;

class TestVerifiableEventAttendee implements IVerifiableEventAttendee
{
    /** @var IVerifiableEvent[] $events */
    protected $events;

    /**
     * TestVerifiableEventAttendee constructor.
     * @param IVerifiableEvent[] $events
     */
    public function __construct(array $events = [])
    {
        $this->events = $events;
    }

    /**
     * @param DateTimeInterface $startDate
     * @param DateTimeInterface|null $endDate
     * @return IVerifiableEvent[]
     */
    public function getEvents(DateTimeInterface $startDate, ?DateTimeInterface $endDate = null): array
    {
        return $this->events;
    }
}
