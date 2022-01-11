<?php

namespace Tests\Models\Rules;

use DateTimeInterface;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules\IRuleUnavailable;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;
use Moves\Eloquent\Verifiable\Rules\Calendar\Traits\TRuleUnavailable;
use Moves\FowlerRecurringEvents\Contracts\ACTemporalExpression;

class TestRuleUnavailable implements IRuleUnavailable
{
    use TRuleUnavailable;

    /** @var DateTimeInterface $start */
    protected $start;

    /** @var DateTimeInterface $end */
    protected $end;

    /** @var ACTemporalExpression $pattern */
    protected $pattern;

    public function __construct(
        DateTimeInterface $start,
        DateTimeInterface $end,
        ?ACTemporalExpression $pattern = null
    )
    {
        $this->start = $start;
        $this->end = $end;
        $this->pattern = $pattern;
    }

    public function getStartTime(IVerifiableEvent $event): DateTimeInterface
    {
        return $this->start;
    }

    public function getEndTime(IVerifiableEvent $event): DateTimeInterface
    {
        return $this->end;
    }

    public function getRecurrencePattern(IVerifiableEvent $event): ?ACTemporalExpression
    {
        return $this->pattern;
    }
}
