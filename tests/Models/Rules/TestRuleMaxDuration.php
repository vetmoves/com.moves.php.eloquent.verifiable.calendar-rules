<?php

namespace Tests\Models\Rules;

use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;
use Moves\Eloquent\Verifiable\Rules\Calendar\Traits\TRuleMaxDuration;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules\IRuleMaxDuration;

class TestRuleMaxDuration implements IRuleMaxDuration
{
    use TRuleMaxDuration;

    /** @var int $duration */
    protected $duration;

    public function __construct(int $duration)
    {
        $this->duration = $duration;
    }

    public function getMaxDurationMinutes(?IVerifiableEvent $event = null): int
    {
        return $this->duration;
    }
}
