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
     * @param DateTimeInterface $date
     * @param IVerifiableEvent|null $event
     * @return IVerifiableEvent[]
     */
    public function getScheduledEventsForDate(DateTimeInterface $date, ?IVerifiableEvent $event = null): array;

    /**
     * @param DateTimeInterface $date
     * @param IVerifiableEvent|null $event
     * @return EventWindow[]
     */
    public function getAvailableWindowsForDate(DateTimeInterface $date, ?IVerifiableEvent $event = null): array;
}

