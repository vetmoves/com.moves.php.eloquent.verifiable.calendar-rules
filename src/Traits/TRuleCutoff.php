<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Traits;

use Carbon\Carbon;
use Moves\Eloquent\Verifiable\Contracts\IVerifiable;
use Moves\Eloquent\Verifiable\Exceptions\VerificationRuleException;
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

        $humanReadableCutoffTime = $cutoffTime->format("M j, 'y g:i A");

        if ($cutoffHasPassed && $this->getCutoffType()->equals(CutoffType::DISALLOW()) )
        {

            throw new VerificationRuleException(
                "Booking for this period ended at {$humanReadableCutoffTime}.",
                $this
            );
        }

        if (!$cutoffHasPassed && $this->getCutoffType()->equals(CutoffType::ALLOW()))
        {
            throw new VerificationRuleException(
                "Booking for this period opens at {$humanReadableCutoffTime}.",
                $this
            );
        }

        return true;
    }
}
