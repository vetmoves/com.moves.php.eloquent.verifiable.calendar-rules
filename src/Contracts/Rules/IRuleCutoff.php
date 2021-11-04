<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules;

use Moves\Eloquent\Verifiable\Contracts\IRule;
use Moves\Eloquent\Verifiable\Rules\Calendar\Enums\CutoffPeriod;
use Moves\Eloquent\Verifiable\Rules\Calendar\Enums\CutoffType;

interface IRuleCutoff extends IRule
{
    public function getCutoffType(): CutoffType;

    public function getCutoffPeriod(): CutoffPeriod;

    public function getCutoffOffsetMinutes(): int;
}
