<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Traits;

use Carbon\Carbon;
use DateTimeInterface;
use Moves\Eloquent\Verifiable\Contracts\IVerifiable;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;
use Moves\Eloquent\Verifiable\Rules\Calendar\Support\EventWindow;

trait TRuleWindows
{
    /**
     * @param DateTimeInterface $date
     * @return EventWindow[]
     */
    public function getAvailableWindowsForDate(DateTimeInterface $date): array
    {
        $targetDate = Carbon::create($date);

        $pattern = $this->getRecurrencePattern();

        if (!is_null($pattern) && !$pattern->includes($date))
        {
            return [];
        }

        $currentTime = Carbon::create($this->getOpenTime());
        $closeTime = Carbon::create($this->getCloseTime());

        if ($pattern) {
            $currentTime->setDate($targetDate->year, $targetDate->month, $targetDate->day);
            $closeTime->setDate($targetDate->year, $targetDate->month, $targetDate->day);
        }

        $windowDuration = $this->getWindowDurationMinutes();
        $bufferDuration = $this->getWindowBufferDurationMinutes();
        $scheduledEvents = $this->getScheduledEventsForDate($date);

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
                        ->addMinutes($bufferDuration);
                    break;
                }
            }

            if (!$windowOverlapsEvents)
            {
                if ($windowEnd <= $closeTime)
                {
                    $windows[] = new EventWindow($windowStart, $windowEnd);
                }

                $currentTime = $windowEnd->copy();

                if ($this->getAlwaysApplyBuffer()) {
                    $currentTime->addMinutes($bufferDuration);
                }
            }
        }

        return $windows;
    }

    /**
     * @param IVerifiable $verifiable
     * @return bool
     * @throws \Exception
     */
    public function verify(IVerifiable $verifiable): bool
    {
        $availableWindows = $this->getAvailableWindowsForDate($verifiable->getStartTime());

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

        throw new \Exception('');
    }
}
