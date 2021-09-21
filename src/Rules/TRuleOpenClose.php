<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Rules;

use Moves\Eloquent\Verifiable\Contracts\IVerifiable;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableOpenClose;

trait TRuleOpenClose
{
    /**
     * @param IVerifiableOpenClose $verifiable
     * @return bool
     * @throws \Exception
     */
    public function verify(IVerifiable $verifiable): bool
    {
        if (
            $verifiable->getStartTime() < $this->getOpenTime() ||
            $verifiable->getEndTime() > $this->getCloseTime()
        ) {
            throw new \Exception('');
        }

        return true;
    }
}