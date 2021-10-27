<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables;

interface IVerifiableCustomAppointment
{
    public function getStartTime(): DateTimeInterface;

    public function getEndTime(): DateTimeInterface;
}
