<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules;

use DateTimeInterface;
use Moves\Eloquent\Verifiable\Contracts\IRule;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;
use Moves\Eloquent\Verifiable\Rules\Calendar\Support\EventWindow;
use Moves\FowlerRecurringEvents\Contracts\ACTemporalExpression;

interface IRuleWindows extends IRule
{
    public function getOpenTime(?IVerifiableEvent $event = null): DateTimeInterface;

    public function getCloseTime(?IVerifiableEvent $event = null): DateTimeInterface;

    public function getRecurrencePattern(?IVerifiableEvent $event = null): ?ACTemporalExpression;

    public function getWindowDurationMinutes(?IVerifiableEvent $event = null): int;

    public function getWindowBufferDurationMinutes(?IVerifiableEvent $event = null): int;

    public function getAlwaysApplyBuffer(?IVerifiableEvent $event = null): bool;

    /**
     * @param IVerifiableEvent|null $event
     * @param DateTimeInterface $date
     * @return IVerifiableEvent[]
     */
    public function getScheduledEventsForDate(?IVerifiableEvent $event = null, DateTimeInterface $date): array;

    /**
     * @param IVerifiableEvent|null $event
     * @param DateTimeInterface $date
     * @return EventWindow[]
     */
    public function getAvailableWindowsForDate(DateTimeInterface $date, ?IVerifiableEvent $event = null): array;
}

