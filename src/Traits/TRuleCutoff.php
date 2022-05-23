<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Traits;

use Carbon\Carbon;
use DateInterval;
use DateTimeInterface;
use Moves\Eloquent\Verifiable\Contracts\IVerifiable;
use Moves\Eloquent\Verifiable\Exceptions\VerificationRuleException;
use Moves\Eloquent\Verifiable\Rules\Calendar\Enums\CutoffPeriod;
use Moves\Eloquent\Verifiable\Rules\Calendar\Enums\CutoffType;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;
use Moves\Eloquent\Verifiable\Rules\Calendar\Support\Formatter;
use Moves\FowlerRecurringEvents\Contracts\ACTemporalExpression;
use Moves\FowlerRecurringEvents\TemporalExpressions\TEDays;

trait TRuleCutoff
{
    public function interpretRecurrencePattern(DateTimeInterface $startTime): ACTemporalExpression
    {
        if ($this->getCutoffPeriod()->equals(CutoffPeriod::WEEK())) {
            $eventDate = Carbon::create($startTime);
            //Go to midnight on the most recent Sunday
            $startDate = $eventDate->copy()
                ->setTime(0, 0)
                ->subDays($eventDate->dayOfWeek % 7);

            return TEDays::build($startDate)->setFrequency(7);
        } else {
            $startDate = Carbon::create($startTime)
                ->setTime(0, 0);
            return TEDays::build($startDate);
        }
    }

    public function getMinBookableDate(): Carbon
    {
        if ($this->getCutoffType()->equals(CutoffType::DISALLOW())) {
            $current = Carbon::today();
            $now = Carbon::now();
            $unit = $this->getCutoffPeriod()->value();

            while ($this->getCutoffTime($current) < $now) {
                $current->add($unit);
            }

            if ($this->getCutoffPeriod()->equals(CutoffPeriod::WEEK())) {
                return $current->subDays($current->dayOfWeek % 7);
            }

            return $current;
        } else {
            return Carbon::today();
        }
    }

    public function getMaxBookableDate(): ?Carbon
    {
        if ($this->getCutoffType()->equals(CutoffType::DISALLOW())) {
            return null;
        } else {
            $current = Carbon::today();
            $now = Carbon::now();
            $unit = $this->getCutoffPeriod()->value();

            while ($this->getCutoffTime($current) < $now) {
                $current->add($unit);
            }

            if ($this->getCutoffPeriod()->equals(CutoffPeriod::WEEK())) {
                return $current->subDays($current->dayOfWeek % 7);
            }

            return $current;
        }
    }

    /**
     * @param IVerifiableEvent $verifiable
     * @return bool
     * @throws \Exception
     */
    public function verify(IVerifiable $verifiable): bool
    {
        $cutoffTime = $this->getCutoffTime($verifiable->getStartTime());

        $cutoffHasPassed = $cutoffTime <= Carbon::now();

        $fmtCutoffTime = $cutoffTime->format(
            __('verifiable_calendar_rules::formats.cutoff.date')
        );

        $cutoffOffsetInterval = new DateInterval("PT{$this->getCutoffOffsetMinutes($verifiable)}M");
        $fmtCutoffOffsetInterval = Formatter::formatInterval($cutoffOffsetInterval);

        $fmtEventStart = $verifiable->getStartTime()->format(
            __('verifiable_calendar_rules::formats.cutoff.event.date.start')
        );
        $fmtEventEnd = $verifiable->getEndTime()->format(
            __('verifiable_calendar_rules::formats.cutoff.event.date.end')
        );

        if ($cutoffHasPassed && $this->getCutoffType($verifiable)->equals(CutoffType::DISALLOW()) )
        {
            throw new VerificationRuleException(
                __('verifiable_calendar_rules::messages.cutoff.disallow', [
                    'cutoff_time' => $fmtCutoffTime,
                    'cutoff_offset' => $fmtCutoffOffsetInterval,
                    'event_start' => $fmtEventStart,
                    'event_end' => $fmtEventEnd
                ]),
                $this
            );
        }

        if (!$cutoffHasPassed && $this->getCutoffType($verifiable)->equals(CutoffType::ALLOW()))
        {
            throw new VerificationRuleException(
                __('verifiable_calendar_rules::messages.cutoff.allow', [
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

    protected function getCutoffTime(DateTimeInterface $startTime): Carbon
    {
        $recurrencePattern = $this->interpretRecurrencePattern($startTime);
        return Carbon::create($recurrencePattern->next())
            ->subMinutes($this->getCutoffOffsetMinutes());
    }
}
