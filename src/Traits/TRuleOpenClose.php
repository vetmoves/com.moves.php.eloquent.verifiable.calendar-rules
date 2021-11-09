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

        $fmtEventStart = $eventStart->format(
            __('verifiable_calendar_rules::formats.open_close.event.date.start')
        );
        $fmtEventEnd = $eventEnd->format(
            __('verifiable_calendar_rules::formats.open_close.event.date.end')
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

        $open = Carbon::create($this->getOpenTime())
            ->setDate($eventStart->year, $eventStart->month, $eventStart->day);
        $close = Carbon::create($this->getCloseTime())
            ->setDate($eventStart->year, $eventStart->month, $eventStart->day);

        $fmtOpenTime = $open->format(
            __('verifiable_calendar_rules::formats.open_close.date.open')
        );
        $fmtCloseTime = $close->format(
            __('verifiable_calendar_rules::formats.open_close.date.close')
        );

        if ($close < $open) {
            throw new VerifiableRuleConfigurationException(
                __('verifiable_calendar_rules::messages.config.rule.open_close_time', [
                    'open_time' => $fmtOpenTime,
                    'close_time' => $fmtCloseTime
                ]),
                $this
            );
        }

        $pattern = $this->getRecurrencePattern();

        if (
            (!is_null($pattern) && !$pattern->includes($eventStart))
            || $eventStart < $open
            || $eventEnd > $close
        ) {
            throw new VerificationRuleException(
                __('verifiable_calendar_rules::messages.open_close', [
                    'open_time' => $fmtOpenTime,
                    'close_time' => $fmtCloseTime,
                    'event_start' => $fmtEventStart,
                    'event_end' => $fmtEventEnd,
                ]),
                $this
            );
        }

        return true;
    }
}
