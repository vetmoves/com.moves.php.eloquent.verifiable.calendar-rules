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

    /** @var bool $alwaysApplyBuffer */
    protected $alwaysApplyBuffer;

    /** @var IVerifiableEvent[] $scheduledEvents */
    protected $scheduledEvents;

    /** @var ACTemporalExpression|null $pattern */
    protected $pattern;

    public function __construct(
        DateTimeInterface $open,
        DateTimeInterface $close,
        int $windowDuration,
        int $bufferDuration = 0,
        bool $alwaysApplyBuffer = false,
        array $scheduledEvents = [],
        ?ACTemporalExpression $pattern = null
    )
    {
        $this->open = $open;
        $this->close = $close;
        $this->windowDuration = $windowDuration;
        $this->bufferDuration = $bufferDuration;
        $this->alwaysApplyBuffer = $alwaysApplyBuffer;
        $this->scheduledEvents = $scheduledEvents;
        $this->pattern = $pattern;
    }

    public function getOpenTime(?IVerifiableEvent $event = null): DateTimeInterface
    {
        return $this->open;
    }

    public function getCloseTime(?IVerifiableEvent $event = null): DateTimeInterface
    {
        return $this->close;
    }

    public function getRecurrencePattern(?IVerifiableEvent $event = null): ?ACTemporalExpression
    {
        return $this->pattern;
    }

    public function getWindowDurationMinutes(?IVerifiableEvent $event = null): int
    {
        return $this->windowDuration;
    }

    public function getWindowBufferDurationMinutes(?IVerifiableEvent $event = null): int
    {
        return $this->bufferDuration;
    }

    public function getAlwaysApplyBuffer(?IVerifiableEvent $event = null): bool
    {
        return $this->alwaysApplyBuffer;
    }

    public function getScheduledEventsForDate(DateTimeInterface $date, ?IVerifiableEvent $event = null): array
    {
        return $this->scheduledEvents;
    }
}
