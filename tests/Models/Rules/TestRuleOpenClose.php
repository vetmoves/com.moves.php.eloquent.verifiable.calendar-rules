<?php

namespace Tests\Models\Rules;

use DateTimeInterface;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules\IRuleOpenClose;
use Moves\Eloquent\Verifiable\Rules\Calendar\Traits\TRuleOpenClose;
use Moves\FowlerRecurringEvents\Contracts\ACTemporalExpression;

class TestRuleOpenClose implements IRuleOpenClose
{
    use TRuleOpenClose;

    /** @var DateTimeInterface $open */
    protected $open;

    /** @var DateTimeInterface $close */
    protected $close;

    /** @var ACTemporalExpression $pattern */
    protected $pattern;

    public function __construct(
        DateTimeInterface $open,
        DateTimeInterface $close,
        ?ACTemporalExpression $pattern = null
    )
    {
        $this->open = $open;
        $this->close = $close;
        $this->pattern = $pattern;
    }

    public function getOpenTime(): DateTimeInterface
    {
        return $this->open;
    }

    public function getCloseTime(): DateTimeInterface
    {
        return $this->close;
    }

    public function getRecurrencePattern(): ?ACTemporalExpression
    {
        return $this->pattern;
    }
}
