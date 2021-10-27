<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Traits;

use Carbon\Carbon;
use Moves\Eloquent\Verifiable\Contracts\IVerifiable;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;

trait TRuleClosure
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

        $closureStart = Carbon::create($this->getStartTime())
            ->setDate($eventStart->year, $eventStart->month, $eventStart->day);
        $closureEnd = Carbon::create($this->getEndTime())
            ->setDate($eventStart->year, $eventStart->month, $eventStart->day);

        if ($closureEnd < $closureStart) {
            throw new \Exception('');
        }

        $pattern = $this->getRecurrencePattern();

        if (
            (is_null($pattern) || $pattern->includes($eventStart))
            && ($eventStart < $closureEnd && $eventEnd > $closureStart)
        )
        {
            throw new \Exception('');
        }

        return true;
    }
}
