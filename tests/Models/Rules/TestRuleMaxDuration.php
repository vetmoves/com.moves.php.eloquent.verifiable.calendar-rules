<?php

namespace Tests\Models\Rules;

use Moves\Eloquent\Verifiable\Rules\Calendar\Traits\TRuleMaxDuration;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules\IRuleMaxDuration;

class TestRuleMaxDuration implements IRuleMaxDuration
{
    use TRuleMaxDuration;

    public function getMaxDurationMinutes(): int
    {
        return 60;
    }
}
