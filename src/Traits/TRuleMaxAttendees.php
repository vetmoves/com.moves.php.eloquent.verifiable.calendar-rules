<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Traits;

use Moves\Eloquent\Verifiable\Contracts\IVerifiable;
use Moves\Eloquent\Verifiable\Exceptions\VerificationRuleException;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;

trait TRuleMaxAttendees
{
    /**
     * @param IVerifiableEvent $verifiable
     * @return bool
     * @throws \Exception
     */
    public function verify(IVerifiable $verifiable): bool
    {
        if (count($verifiable->getAttendees()) > $this->getMaxAttendees())
        {
            throw new VerificationRuleException(
                __('verifiable_calendar_rules.messages.max_attendees', [
                    'expected' => $this->getMaxAttendees(),
                    'actual' => count($verifiable->getAttendees())
                ]),
                $this
            );
        }

        return true;
    }
}
