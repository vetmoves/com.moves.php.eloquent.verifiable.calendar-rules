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
        $eventEnd = Carbon::create($verifiable->getEndTime())
            ->setDate($eventStart->year, $eventStart->month, $eventStart->day);

        $fmtEventStart = $eventStart->format(
            __('verifiable_calendar_rules::formats.closure.event.date.start')
        );
        $fmtEventEnd = $eventEnd->format(
            __('verifiable_calendar_rules::formats.closure.event.date.end')
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

        $closureStart = Carbon::create($this->getStartTime())
            ->setDate($eventStart->year, $eventStart->month, $eventStart->day);
        $closureEnd = Carbon::create($this->getEndTime())
            ->setDate($eventStart->year, $eventStart->month, $eventStart->day);

        $fmtClosureStart = $closureStart->format(
            __('verifiable_calendar_rules::formats.closure.date.start')
        );
        $fmtClosureEnd = $closureEnd->format(
            __('verifiable_calendar_rules::formats.closure.date.end')
        );

        if ($closureEnd < $closureStart) {
            throw new VerifiableRuleConfigurationException(
                __('verifiable_calendar_rules::messages.config.rule.start_end_time', [
                    'closure_start' => $fmtClosureStart,
                    'closure_end' => $fmtClosureEnd
                ]),
                $this
            );
        }

        $pattern = $this->getRecurrencePattern();

        if (
            (is_null($pattern) || $pattern->includes($eventStart))
            && ($eventStart < $closureEnd && $eventEnd > $closureStart)
        )
        {
            throw new VerificationRuleException(
                __('verifiable_calendar_rules::messages.closure', [
                    'closure_start' => $fmtClosureStart,
                    'closure_end' => $fmtClosureEnd,
                    'event_start' => $fmtEventStart,
                    'event_end' => $fmtEventEnd
                ]),
                $this
            );
        }

        return true;
    }
}
