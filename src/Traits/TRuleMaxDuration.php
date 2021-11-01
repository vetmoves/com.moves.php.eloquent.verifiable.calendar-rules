<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Traits;

use Carbon\Carbon;
use DateInterval;
use Illuminate\Support\Str;
use Moves\Eloquent\Verifiable\Contracts\IVerifiable;
use Moves\Eloquent\Verifiable\Exceptions\VerifiableConfigurationException;
use Moves\Eloquent\Verifiable\Exceptions\VerificationRuleException;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;
use Moves\Eloquent\Verifiable\Rules\Calendar\Support\Formatter;

trait TRuleMaxDuration
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

        $duration = $eventStart->diffInMinutes($eventEnd);

        if ($duration > $this->getMaxDurationMinutes()) {
            $interval = new DateInterval("PT{$this->getMaxDurationMinutes()}M");
            $humanReadableInterval = Formatter::formatInterval($interval);

            throw new VerificationRuleException(
                "This event cannot be longer than {$humanReadableInterval}.",
                $this
            );
        }

        return true;
    }
}
