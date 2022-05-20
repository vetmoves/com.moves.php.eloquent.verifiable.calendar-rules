<?php

namespace Tests\Models\Rules;

use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules\IRuleMaxAttendees;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;
use Moves\Eloquent\Verifiable\Rules\Calendar\Traits\TRuleMaxAttendees;

class TestRuleMaxAttendees implements IRuleMaxAttendees
{
    use TRuleMaxAttendees;

    /** @var int $maxAttendees */
    protected $maxAttendees;

    public function __construct(int $maxAttendees)
    {
        $this->maxAttendees = $maxAttendees;
    }

    public function getMaxAttendees(?IVerifiableEvent $event = null): int
    {
        return $this->maxAttendees;
    }
}
