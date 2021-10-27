<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Rules;

use Moves\Eloquent\Verifiable\Contracts\IVerifiable;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableBlock;

trait TRuleBlock
{
    use TRule;

    /**
     * @param IVerifiableBlock $verifiable
     * @return bool
     * @throws \Exception
     */
    public function verify(IVerifiable $verifiable): bool
    {
        if (
            $this->overlaps(
                $verifiable->getStartTime(),
                $verifiable->getEndTime()
            )
        ) {
            throw new \Exception('');
        }

        return true;
    }
}