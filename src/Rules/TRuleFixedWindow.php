<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Rules;

use Moves\Eloquent\Verifiable\Contracts\IVerifiable;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableWindow;

trait TRuleFixedWindow
{
    use TRule;

    /**
     * @param IVerifiableWindow $verifiable
     * @return bool
     * @throws \Exception
     */
    public function verify(IVerifiable $verifiable): bool
    {
        // if (
        //     $verifiable->getStartTime() < $this->getBlockStartTime() ||
        //     $verifiable->getEndTime() > $this->getBlockEndTime()
        // ) {
        //     throw new \Exception('');
        // }

        if (
            $this->overlaps(
                $verifiable->getStartTime(),
                $verifiable->getEndTime() + $this->getBufferDuration(),
            )
        ) {
            throw new \Exception('');
        }

        return true;
    }
}
