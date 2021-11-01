<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Traits;

use Carbon\Carbon;
use DateInterval;
use Moves\Eloquent\Verifiable\Contracts\IVerifiable;
use Moves\Eloquent\Verifiable\Exceptions\VerificationRuleException;
use Moves\Eloquent\Verifiable\Rules\Calendar\Enums\CutoffType;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;
use Moves\Eloquent\Verifiable\Rules\Calendar\Support\Formatter;

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

        $fmtCutoffTime = $cutoffTime->format(
            __('verifiable_calendar_rules.formats.cutoff.date')
        );

        $cutoffOffsetInterval = new DateInterval("PT{$this->getCutoffOffsetMinutes()}M");
        $fmtCutoffOffsetInterval = Formatter::formatInterval($cutoffOffsetInterval);

        $fmtEventStart = $startTime->format(
            __('verifiable_calendar_rules.formats.cutoff.event.date.start')
        );
        $fmtEventEnd = $verifiable->getEndTime()->format(
            __('verifiable_calendar_rules.formats.cutoff.event.date.end')
        );

        if ($cutoffHasPassed && $this->getCutoffType()->equals(CutoffType::DISALLOW()) )
        {
            throw new VerificationRuleException(
                __('verifiable_calendar_rules.messages.cutoff.disallow', [
                    'cutoff_time' => $fmtCutoffTime,
                    'cutoff_offset' => $fmtCutoffOffsetInterval,
                    'event_start' => $fmtEventStart,
                    'event_end' => $fmtEventEnd
                ]),
                $this
            );
        }

        if (!$cutoffHasPassed && $this->getCutoffType()->equals(CutoffType::ALLOW()))
        {
            throw new VerificationRuleException(
                __('verifiable_calendar_rules.messages.cutoff.allow', [
                    'cutoff_time' => $fmtCutoffTime,
                    'cutoff_offset' => $fmtCutoffOffsetInterval,
                    'event_start' => $fmtEventStart,
                    'event_end' => $fmtEventEnd
                ]),
                $this
            );
        }

        return true;
    }
}
