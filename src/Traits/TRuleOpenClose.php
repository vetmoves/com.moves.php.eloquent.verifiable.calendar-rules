<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Traits;

use Carbon\Carbon;
use Moves\Eloquent\Verifiable\Contracts\IVerifiable;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;

trait TRuleOpenClose
{
    /**
     * @param IVerifiableEvent $verifiable
     * @return bool
     * @throws \Exception
     */
    public function verify(IVerifiable $verifiable): bool
    {
        $eventStart = Carbon::create($verifiable->getStartTime());
        $eventEnd = Carbon::create($verifiable->getEndTime())
            ->setDate($eventStart->year, $eventStart->month, $eventStart->day);

        if ($eventEnd < $eventStart) {
            throw new \Exception('');
        }

        $open = Carbon::create($this->getOpenTime())
            ->setDate($eventStart->year, $eventStart->month, $eventStart->day);
        $close = Carbon::create($this->getCloseTime())
            ->setDate($eventStart->year, $eventStart->month, $eventStart->day);

        if ($close < $open) {
            throw new \Exception('');
        }

        $pattern = $this->getRecurrencePattern();

        if (
            (!is_null($pattern) && !$pattern->includes($eventStart))
            || $eventStart < $open
            || $eventEnd > $close
        ) {
            throw new \Exception('');
        }

        return true;
    }
}
