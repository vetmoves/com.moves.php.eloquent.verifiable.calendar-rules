<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules;

use DateTimeInterface;

interface IRuleOpenClose
{
    public function getOpenTime(): DateTimeInterface;

    public function getCloseTime(): DateTimeInterface;
}