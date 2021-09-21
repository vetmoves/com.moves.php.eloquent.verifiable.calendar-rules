<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables;

use DateTimeInterface;
use Moves\Eloquent\Verifiable\Contracts\IVerifiable;

interface IVerifiableOpenClose extends IVerifiable
{
    public function getStartTime(): DateTimeInterface;

    public function getEndTime(): DateTimeInterface;
}

class Appointment implements IVerifiableOpenClose {
    public function getStartTime(): DateTimeInterface {
        return $this->start_time;
    }

    public function getEndTime(): DateTimeInterface {
        $this->end_time;
    }
}