<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables;

use DateTimeInterface;
use Moves\Eloquent\Verifiable\Contracts\IVerifiable;

interface IVerifiableOpenClose extends IVerifiable
{
    public function getStartTime(): DateTimeInterface;

    public function getEndTime(): DateTimeInterface;
}