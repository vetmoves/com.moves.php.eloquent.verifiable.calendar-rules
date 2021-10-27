<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Traits;

use Carbon\Carbon;
use Moves\Eloquent\Verifiable\Contracts\IVerifiable;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;

trait TRuleMaxDuration
{
    /**
     * @param IVerifiableEvent $verifiable
     * @return bool
     * @throws \Exception
     */
    public function verify(IVerifiable $verifiable): bool
    {
        $start = Carbon::create($verifiable->getStartTime());
        $end = Carbon::create($verifiable->getEndTime())
            ->setDate($start->year, $start->month, $start->day);

        $duration = $start->diffInMinutes($end, false);

        if ($duration < 0) {
            throw new \Exception('');
        }

        if ($duration > $this->getMaxDurationMinutes()) {
            throw new \Exception('');
        }

        return true;
    }
}
