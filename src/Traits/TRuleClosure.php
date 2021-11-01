<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Traits;

use Carbon\Carbon;
use Moves\Eloquent\Verifiable\Contracts\IVerifiable;
use Moves\Eloquent\Verifiable\Exceptions\VerifiableConfigurationException;
use Moves\Eloquent\Verifiable\Exceptions\VerifiableRuleConfigurationException;
use Moves\Eloquent\Verifiable\Exceptions\VerificationRuleException;
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
            throw new VerifiableConfigurationException(
                'Event end time must be after event start time.',
                $verifiable
            );
        }

        $closureStart = Carbon::create($this->getStartTime())
            ->setDate($eventStart->year, $eventStart->month, $eventStart->day);
        $closureEnd = Carbon::create($this->getEndTime())
            ->setDate($eventStart->year, $eventStart->month, $eventStart->day);

        if ($closureEnd < $closureStart) {
            throw new VerifiableRuleConfigurationException(
                'Closure end time must be after closure start time.',
                $this
            );
        }

        $pattern = $this->getRecurrencePattern();

        if (
            (is_null($pattern) || $pattern->includes($eventStart))
            && ($eventStart < $closureEnd && $eventEnd > $closureStart)
        )
        {
            $closureStartFormatted = $closureStart->format("M j, 'y g:i A");
            $closureEndFormatted = $closureEnd->format("M j, 'y g:i A");

            throw new VerificationRuleException(
            "This event cannot be booked between {$closureStartFormatted} and {$closureEndFormatted}.",
                $this
            );
        }

        return true;
    }
}
