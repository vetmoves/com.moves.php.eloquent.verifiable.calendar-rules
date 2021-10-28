<?php

namespace Tests\Models\Rules;

use DateTimeInterface;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules\IRuleWindows;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;
use Moves\Eloquent\Verifiable\Rules\Calendar\Traits\TRuleWindows;
use Moves\FowlerRecurringEvents\Contracts\ACTemporalExpression;

class TestRuleWindows implements IRuleWindows
{
    use TRuleWindows;

    /** @var DateTimeInterface $open */
    protected $open;

    /** @var DateTimeInterface $close */
    protected $close;

    /** @var int $windowDuration */
    protected $windowDuration;

    /** @var int $bufferDuration */
    protected $bufferDuration;

    /** @var IVerifiableEvent[] $scheduledEvents */
    protected $scheduledEvents;

    /** @var ACTemporalExpression|null $pattern */
    protected $pattern;

    public function __construct(
        DateTimeInterface $open,
        DateTimeInterface $close,
        int $windowDuration,
        int $bufferDuration = 0,
        array $scheduledEvents = [],
        ?ACTemporalExpression $pattern = null
    )
    {
        $this->open = $open;
        $this->close = $close;
        $this->windowDuration = $windowDuration;
        $this->bufferDuration = $bufferDuration;
        $this->scheduledEvents = $scheduledEvents;
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

    public function getWindowDurationMinutes(): int
    {
        return $this->windowDuration;
    }

    public function getWindowBufferDurationMinutes(): int
    {
        return $this->bufferDuration;
    }

    public function getScheduledEventsForDate(DateTimeInterface $date): array
    {
        return $this->scheduledEvents;
    }
}
