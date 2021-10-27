<?php

namespace Tests\Models\Rules;

use DateTimeInterface;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules\IRuleClosure;
use Moves\Eloquent\Verifiable\Rules\Calendar\Traits\TRuleClosure;
use Moves\FowlerRecurringEvents\Contracts\ACTemporalExpression;

class TestRuleClosure implements IRuleClosure
{
    use TRuleClosure;

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

    public function getStartTime(): DateTimeInterface
    {
        return $this->start;
    }

    public function getEndTime(): DateTimeInterface
    {
        return $this->end;
    }

    public function getRecurrencePattern(): ?ACTemporalExpression
    {
        return $this->pattern;
    }
}
