<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables;

interface IVerifiableWindow
{
    public function containsAppointments(): bool;

    public function isFixed(): bool;

    public function isDynamic(): bool;
}