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
        $date = Carbon::create($date);
        $pattern = $this->getRecurrencePattern();

        if (is_null($pattern) ?
            $date->format('Y-m-d') !== $this->getOpenTime()->format('Y-m-d') :
            !$pattern->includes($date)
        ) {
            return [];
        }

        $diff = Carbon::create($this->getOpenTime($event))->diff(Carbon::create($this->getCloseTime($event)));

        $currentTime = Carbon::create($this->getOpenTime($event))
            ->setTimezone($date->getTimezone())
            ->setDate($date->year, $date->month, $date->day);
        $closeTime = $currentTime->copy()->add($diff);
        $targetDate = Carbon::create($date)->setTime($currentTime->hour, $currentTime->minute);

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
        $availableWindows = $this->getAvailableWindowsForDate($verifiable->getStartTime());

        $dateFormat = 'Y-m-d H:i:s';

        $verifiableStartTimeUtc = $verifiable->getStartTime()->copy()->setTimezone('UTC')->format($dateFormat);
        $verifiableEndTimeUtc = $verifiable->getEndTime()->copy()->setTimezone('UTC')->format($dateFormat);

        foreach ($availableWindows as $window)
        {
            if (
                $window->getStartTime()->format($dateFormat) === $verifiableStartTimeUtc
                && $window->getEndTime()->format($dateFormat) === $verifiableEndTimeUtc
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
