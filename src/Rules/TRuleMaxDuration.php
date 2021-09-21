<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Rules;

use Moves\Eloquent\Verifiable\Contracts\IVerifiable;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableMaxDuration;

trait TRuleMaxDuration
{
    /**
     * @param IVerifiableMaxDuration $verifiable
     * @return bool
     * @throws \Exception
     */
    public function verify(IVerifiable $verifiable): bool
    {
        if ($verifiable->getDurationMinutes() > $this->getMaxDurationMinutes()) {
            throw new \Exception('');
        }

        return true;
    }
}