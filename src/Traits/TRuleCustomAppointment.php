<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Traits;

use Moves\Eloquent\Verifiable\Contracts\IVerifiable;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableCustomAppointment;

trait TRuleCustomAppointment
{
    use TRule;

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
