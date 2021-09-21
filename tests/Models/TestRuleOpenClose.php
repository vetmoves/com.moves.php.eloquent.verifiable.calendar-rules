<?php

namespace Tests\Models;

use DateTimeInterface;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules\IRuleOpenClose;
use Moves\Eloquent\Verifiable\Rules\Calendar\Rules\TRuleOpenClose;

class TestRuleOpenClose implements IRuleOpenClose
{
    use TRuleOpenClose;

    public function getOpenTime(): DateTimeInterface
    {
        return new \DateTime('2021-01-01 08:00:00');
    }

    public function getCloseTime(): DateTimeInterface
    {
        return new \DateTime('2021-01-01 17:00:00');
    }
}