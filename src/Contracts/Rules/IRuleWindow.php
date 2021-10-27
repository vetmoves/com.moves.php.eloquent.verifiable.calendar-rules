
<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules;

use DateTimeInterface;

interface IRuleOpenClose
{
    public function containsAppointments(): bool;

    public function isFixed(): bool;

    public function isDynamic(): bool;

    public function getFixedStartTime(): DateTimeInterface;

    public function getFixedEndTime(): DateTimeInterface;

    public function isClaimed(): bool;
}

