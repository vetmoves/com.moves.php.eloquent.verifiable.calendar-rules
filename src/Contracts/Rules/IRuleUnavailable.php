<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules;

use DateTimeInterface;
use Moves\Eloquent\Verifiable\Contracts\IRule;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;
use Moves\FowlerRecurringEvents\Contracts\ACTemporalExpression;

/**
 * Interface IRuleOpenClose
 *
 * Rule which verifies that an event takes place between a certain open and close time.
 * Close time is currently limited to occur after open time on the same calendar date.
 * That is, close time after midnight is not currently supported.
 */
interface IRuleUnavailable extends IRule
{
    public function getStartTime(IVerifiableEvent $event): DateTimeInterface;

    public function getEndTime(IVerifiableEvent $event): DateTimeInterface;

    public function getRecurrencePattern(IVerifiableEvent $event): ?ACTemporalExpression;
}
