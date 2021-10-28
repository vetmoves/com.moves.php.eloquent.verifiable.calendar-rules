<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules;

use DateTimeInterface;
use Moves\Eloquent\Verifiable\Contracts\IRule;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;
use Moves\Eloquent\Verifiable\Rules\Calendar\Support\EventWindow;
use Moves\FowlerRecurringEvents\Contracts\ACTemporalExpression;

interface IRuleWindows extends IRule
{
    public function getOpenTime(): DateTimeInterface;

    public function getCloseTime(): DateTimeInterface;

    public function getRecurrencePattern(): ?ACTemporalExpression;

    public function getWindowDurationMinutes(): int;

    public function getWindowBufferDurationMinutes(): int;

    /**
     * @param DateTimeInterface $date
     * @return IVerifiableEvent[]
     */
    public function getScheduledEventsForDate(DateTimeInterface $date): array;

    /**
     * @param DateTimeInterface $date
     * @return EventWindow[]
     */
    public function getAvailableWindowsForDate(DateTimeInterface $date): array;
}

