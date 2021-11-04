<?php

namespace Tests\Models\Rules;

use Moves\Eloquent\Verifiable\Rules\Calendar\Enums\CutoffPeriod;
use Moves\Eloquent\Verifiable\Rules\Calendar\Enums\CutoffType;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules\IRuleCutoff;
use Moves\Eloquent\Verifiable\Rules\Calendar\Traits\TRuleCutoff;

class TestRuleCutoff implements IRuleCutoff
{
    use TRuleCutoff;

    /** @var CutoffType $cutoffType */
    protected $cutoffType;

    /** @var CutoffPeriod $cutoffPeriod */
    protected $cutoffPeriod;

    /** @var int $cutoffOffsetMinutes */
    protected $cutoffOffsetMinutes;

    public function __construct(CutoffType $cutoffType, CutoffPeriod $cutoffPeriod, int $cutoffOffsetMinutes)
    {
        $this->cutoffType = $cutoffType;
        $this->cutoffPeriod = $cutoffPeriod;
        $this->cutoffOffsetMinutes = $cutoffOffsetMinutes;
    }

    public function getCutoffType(): CutoffType
    {
        return $this->cutoffType;
    }

    public function getCutoffPeriod(): CutoffPeriod
    {
        return $this->cutoffPeriod;
    }

    public function getCutoffOffsetMinutes(): int
    {
        return $this->cutoffOffsetMinutes;
    }
}
