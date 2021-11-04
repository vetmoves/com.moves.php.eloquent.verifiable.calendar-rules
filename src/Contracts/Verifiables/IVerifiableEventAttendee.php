<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables;

use DateTimeInterface;

interface IVerifiableEventAttendee
{
    /**
     * @param DateTimeInterface $startDate
     * @param DateTimeInterface|null $endDate
     * @return IVerifiableEvent[]
     */
    public function getEvents(DateTimeInterface $startDate, ?DateTimeInterface $endDate = null): array;
}
