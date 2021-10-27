<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Traits;

use Carbon\Carbon;
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
        $eventStartTime = Carbon::create($verifiable->getStartTime());
        $eventEndTime = Carbon::create($verifiable->getEndTime())
            ->setDate($eventStartTime->year, $eventStartTime->month, $eventStartTime->day);

        if ($eventEndTime < $eventStartTime) {
            throw new \Exception('');
        }

        $openTime = Carbon::create($this->getOpenTime())
            ->setDate($eventStartTime->year, $eventStartTime->month, $eventStartTime->day);
        $closeTime = Carbon::create($this->getCloseTime())
            ->setDate($eventStartTime->year, $eventStartTime->month, $eventStartTime->day);

        if ($closeTime < $openTime) {
            throw new \Exception('');
        }

        $pattern = $this->getRecurrencePattern();

        if (
            (!is_null($pattern) && !$pattern->includes($eventStartTime))
            || $eventStartTime < $openTime
            || $eventEndTime > $closeTime
        ) {
            throw new \Exception('');
        }

        return true;
    }
}
