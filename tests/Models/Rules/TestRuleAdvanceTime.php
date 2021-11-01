<?php

namespace Tests\Models\Rules;

use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules\IRuleAdvanceTime;
use Moves\Eloquent\Verifiable\Rules\Calendar\Enums\AdvanceType;
use Moves\Eloquent\Verifiable\Rules\Calendar\Traits\TRuleAdvanceTime;

class TestRuleAdvanceTime implements IRuleAdvanceTime
{
    use TRuleAdvanceTime;

    /** @var AdvanceType $advanceType */
    protected $advanceType;

    /** @var int $advance */
    protected $advance;

    public function __construct(AdvanceType $advanceType, int $advance)
    {
        $this->advanceType = $advanceType;
        $this->advance = $advance;
    }

    public function getAdvanceType(): AdvanceType
    {
        return $this->advanceType;
    }

    public function getAdvanceMinutes(): int
    {
        return $this->advance;
    }
}
