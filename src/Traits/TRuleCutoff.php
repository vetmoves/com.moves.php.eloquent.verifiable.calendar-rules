<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Traits;

use Carbon\Carbon;
use Moves\Eloquent\Verifiable\Contracts\IVerifiable;
use Moves\Eloquent\Verifiable\Rules\Calendar\Enums\CutoffType;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;

trait TRuleCutoff
{
    /**
     * @param IVerifiableEvent $verifiable
     * @return bool
     * @throws \Exception
     */
    public function verify(IVerifiable $verifiable): bool
    {
        $startTime = Carbon::create($verifiable->getStartTime());
        $cutoffPeriodStart = $startTime->setTime(0, 0);
        $cutoffTime = $cutoffPeriodStart->subMinutes($this->getCutoffOffsetMinutes());

        $cutoffHasPassed = $cutoffTime <= Carbon::now();
        $cutoffDisallow = $this->getCutoffType()->equals(CutoffType::DISALLOW());

        //If cutoff has passed and type is to disallow, OR cutoff has not passed and type is to allow...
        if ($cutoffHasPassed == $cutoffDisallow) {
            throw new \Exception('');
        }

        return true;
    }
}
