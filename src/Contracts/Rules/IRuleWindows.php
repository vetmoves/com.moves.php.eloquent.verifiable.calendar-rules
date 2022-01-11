<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules;

use DateTimeInterface;
use Moves\Eloquent\Verifiable\Contracts\IRule;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;
use Moves\Eloquent\Verifiable\Rules\Calendar\Support\EventWindow;
use Moves\FowlerRecurringEvents\Contracts\ACTemporalExpression;

interface IRuleWindows extends IRule
{
    public function getOpenTime(IVerifiableEvent $event): DateTimeInterface;

    public function getCloseTime(IVerifiableEvent $event): DateTimeInterface;

    public function getRecurrencePattern(IVerifiableEvent $event): ?ACTemporalExpression;

    public function getWindowDurationMinutes(IVerifiableEvent $event): int;

    public function getWindowBufferDurationMinutes(IVerifiableEvent $event): int;

    public function getAlwaysApplyBuffer(IVerifiableEvent $event): bool;

    /**
     * @param IVerifiableEvent $event
     * @param DateTimeInterface $date
     * @return IVerifiableEvent[]
     */
    public function getScheduledEventsForDate(IVerifiableEvent $event, DateTimeInterface $date): array;

    /**
     * @param IVerifiableEvent $event
     * @param DateTimeInterface $date
     * @return EventWindow[]
     */
    public function getAvailableWindowsForDate(IVerifiableEvent $event, DateTimeInterface $date): array;
}

