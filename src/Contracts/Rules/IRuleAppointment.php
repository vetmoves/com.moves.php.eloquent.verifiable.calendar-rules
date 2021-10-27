<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Rules;

use DateTimeInterface;

interface IRuleAppointment
{
    public function getMaxConcurrentAppointments(): int;

    public function getCurrentScheduled(): int;

    public function getStartTime(): DateTimeInterface;

    public function getEndTime(): DateTimeInterface;

    public function 
}