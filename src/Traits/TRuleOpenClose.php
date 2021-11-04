<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Traits;

use Carbon\Carbon;
use Moves\Eloquent\Verifiable\Contracts\IVerifiable;
use Moves\Eloquent\Verifiable\Exceptions\VerifiableConfigurationException;
use Moves\Eloquent\Verifiable\Exceptions\VerifiableRuleConfigurationException;
use Moves\Eloquent\Verifiable\Exceptions\VerificationRuleException;
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
            throw new VerifiableConfigurationException(
                'Event end time must be after event start time.',
                $verifiable
            );
        }

        $open = Carbon::create($this->getOpenTime())
            ->setDate($eventStart->year, $eventStart->month, $eventStart->day);
        $close = Carbon::create($this->getCloseTime())
            ->setDate($eventStart->year, $eventStart->month, $eventStart->day);

        if ($close < $open) {
            throw new VerifiableRuleConfigurationException(
                'Open time must be before Close time',
                $this
            );
        }

        $pattern = $this->getRecurrencePattern();

        if (
            (!is_null($pattern) && !$pattern->includes($eventStart))
            || $eventStart < $open
            || $eventEnd > $close
        ) {
            $formattedOpenTime = $open->format('g:i A');
            $formattedCloseTime = $close->format('g:i A');

            throw new VerificationRuleException(
                "This event must be booked between {$formattedOpenTime} and {$formattedCloseTime}.",
                $this
            );
        }

        return true;
    }
}
