<?php

namespace Tests\Models\Rules;

use Moves\Eloquent\Verifiable\Contracts\IVerifiable;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules\IRuleAdvanceTime;
use Moves\Eloquent\Verifiable\Rules\Calendar\Traits\TRuleAdvanceTime;

class TestRuleAdvanceTime implements IRuleAdvanceTime
{
    use TRuleAdvanceTime;

    /** @var int $advance */
    protected $advance;

    public function __construct(int $advance)
    {
        $this->advance = $advance;
    }

    public function getAdvanceMinutes(): int
    {
        return $this->advance;
    }
}
