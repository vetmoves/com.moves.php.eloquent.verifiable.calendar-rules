<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Rules;

use Moves\Eloquent\Verifiable\Contracts\IVerifiable;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableAppointment;

trait TRuleAppointment
{
    use TRule;

    /**
     * @param IVerifiableAppointment $verifiable
     * @return bool
     * @throws \Exception
     */
    public function verify(IVerifiable $verifiable): bool
    {
        if (
            $verifiable->patientStatus === 'NEW_PATIENT' &&
            $verifiable->procedure === 'NONE' &&
            $this->hasCaseHistory()
        ) {
            throw new \Exception('');
        }

        if (
            
        ) {
            throw new \Exception('');
        }

        return true;
    }
}