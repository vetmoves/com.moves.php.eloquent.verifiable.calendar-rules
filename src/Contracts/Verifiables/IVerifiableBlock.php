<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables;

interface IVerifiableBlock
{
    public function getStartTime(): DateTimeInterface;

    public function getEndTime(): DateTimeInterface;
}