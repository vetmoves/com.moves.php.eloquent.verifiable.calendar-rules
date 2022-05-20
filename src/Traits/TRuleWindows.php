<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Traits;

use Carbon\Carbon;
use DateTimeInterface;
use Moves\Eloquent\Verifiable\Contracts\IVerifiable;
use Moves\Eloquent\Verifiable\Exceptions\VerificationRuleException;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;
use Moves\Eloquent\Verifiable\Rules\Calendar\Support\EventWindow;

trait TRuleWindows
{
    /**
     * @param DateTimeInterface $date
     * @return EventWindow[]
     */
    public function getAvailableWindowsForDate(DateTimeInterface $date, ?IVerifiableEvent $event = null): array
    {
        $targetDate = Carbon::create($date);
        $eventDayStart = Carbon::create($this->getOpenTime($event))
            ->setTimezone($date->getTimezone())
            ->setTime(0, 0);

        $pattern = $this->getRecurrencePattern($event);

        if (is_null($pattern)
            ? $eventDayStart != $targetDate->copy()->setTime(0, 0)
            : !$pattern->includes($date)
        ) {
            return [];
        }

        $currentTime = Carbon::create($this->getOpenTime($event))->setTimezone($date->getTimezone());
        $closeTime = Carbon::create($this->getCloseTime($event))->setTimezone($date->getTimezone());

        if ($pattern) {
            $diff = $currentTime->diff($targetDate);

            $currentTime->add($diff);
            $closeTime->add($diff);
        }

        $windowDuration = $this->getWindowDurationMinutes($event);
        $bufferDuration = $this->getWindowBufferDurationMinutes($event);
        $scheduledEvents = $this->getScheduledEventsForDate($date, $event);

        $windows = [];

        while ($currentTime < $closeTime)
        {
            $windowOverlapsEvents = false;

            $windowStart = $currentTime->copy();
            $windowEnd = $windowStart->copy()->addMinutes($windowDuration);
            $windowEndWithBuffer = $windowEnd->copy()->addMinutes($bufferDuration);

            foreach ($scheduledEvents as $event)
            {
                if ($windowStart < $event->getEndTime() && $windowEndWithBuffer > $event->getStartTime())
                {
                    $windowOverlapsEvents = true;
                    $currentTime = Carbon::create($event->getEndTime())
                        ->setTimezone($date->getTimezone())
                        ->addMinutes($bufferDuration);
                    break;
                }
            }

            if (!$windowOverlapsEvents)
            {
                if ($windowEnd <= $closeTime)
                {
                    $windows[] = new EventWindow(
                        $windowStart->copy()->setTimezone('UTC'),
                        $windowEnd->copy()->setTimezone('UTC')
                    );
                }

                $currentTime = $windowEnd->copy();

                if ($this->getAlwaysApplyBuffer($event)) {
                    $currentTime->addMinutes($bufferDuration);
                }
            }
        }

        return $windows;
    }

    /**
     * @param IVerifiableEvent $verifiable
     * @return bool
     * @throws \Exception
     */
    public function verify(IVerifiable $verifiable): bool
    {
        $availableWindows = $this->getAvailableWindowsForDate($verifiable, $verifiable->getStartTime());

        $dateFormat = 'Y-m-d H:i:s';

        foreach ($availableWindows as $window)
        {
            if (
                $window->getStartTime()->format($dateFormat) === $verifiable->getStartTime()->format($dateFormat)
                && $window->getEndTime()->format($dateFormat) === $verifiable->getEndTime()->format($dateFormat)
            )
            {
                return true;
            }
        }

        $fmtOpenTime = $this->getOpenTime($verifiable)->format(
            __('verifiable_calendar_rules::formats.windows.date.open')
        );
        $fmtCloseTime = $this->getCloseTime($verifiable)->format(
            __('verifiable_calendar_rules::formats.windows.date.close')
        );

        $fmtEventStart = $verifiable->getStartTime()->format(
            __('verifiable_calendar_rules::formats.windows.event.date.start')
        );
        $fmtEventEnd = $verifiable->getEndTime()->format(
            __('verifiable_calendar_rules::formats.windows.event.date.end')
        );

        throw new VerificationRuleException(
            __('verifiable_calendar_rules::messages.windows', [
                'open_time' => $fmtOpenTime,
                'close_time' => $fmtCloseTime,
                'event_start' => $fmtEventStart,
                'event_end' => $fmtEventEnd
            ]),
            $this
        );
    }
}
