<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Traits;

use Carbon\Carbon;
use Moves\Eloquent\Verifiable\Contracts\IVerifiable;
use Moves\Eloquent\Verifiable\Exceptions\VerifiableConfigurationException;
use Moves\Eloquent\Verifiable\Exceptions\VerifiableRuleConfigurationException;
use Moves\Eloquent\Verifiable\Exceptions\VerificationRuleException;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;

trait TRuleUnavailable
{
    /**
     * @param IVerifiableEvent $verifiable
     * @return bool
     * @throws \Exception
     */
    public function verify(IVerifiable $verifiable): bool
    {
        $eventStart = Carbon::create($verifiable->getStartTime());
        $eventEnd = Carbon::create($verifiable->getEndTime());

        $fmtEventStart = $eventStart->format(
            __('verifiable_calendar_rules::formats.unavailable.event.date.start')
        );
        $fmtEventEnd = $eventEnd->format(
            __('verifiable_calendar_rules::formats.unavailable.event.date.end')
        );

        if ($eventEnd < $eventStart) {
            throw new VerifiableConfigurationException(
                __('verifiable_calendar_rules::messages.config.event.start_end_time', [
                    'event_start' => $fmtEventStart,
                    'event_end' => $fmtEventEnd
                ]),
                $verifiable
            );
        }

        $unavailableDuration = Carbon::create($this->getStartTime($verifiable))
            ->diff(Carbon::create($this->getEndTime($verifiable)));
        $unavailableStart = Carbon::create($this->getStartTime($verifiable))
            ->setDate($eventStart->year, $eventStart->month, $eventStart->day);
        $unavailableEnd = $unavailableStart->copy()->add($unavailableDuration);

        $fmtUnavailableStart = $unavailableStart->format(
            __('verifiable_calendar_rules::formats.unavailable.date.start')
        );
        $fmtUnavailableEnd = $unavailableEnd->format(
            __('verifiable_calendar_rules::formats.unavailable.date.end')
        );

        if ($unavailableEnd < $unavailableStart) {
            throw new VerifiableRuleConfigurationException(
                __('verifiable_calendar_rules::messages.config.rule.start_end_time', [
                    'unavailable_start' => $fmtUnavailableStart,
                    'unavailable_end' => $fmtUnavailableEnd
                ]),
                $this
            );
        }

        $pattern = $this->getRecurrencePattern($verifiable);

        if (
            (is_null($pattern) || $pattern->includes($eventStart))
            && ($eventStart < $unavailableEnd && $eventEnd > $unavailableStart)
        )
        {
            throw new VerificationRuleException(
                __('verifiable_calendar_rules::messages.unavailable', [
                    'unavailable_start' => $fmtUnavailableStart,
                    'unavailable_end' => $fmtUnavailableEnd,
                    'event_start' => $fmtEventStart,
                    'event_end' => $fmtEventEnd
                ]),
                $this
            );
        }

        return true;
    }
}
