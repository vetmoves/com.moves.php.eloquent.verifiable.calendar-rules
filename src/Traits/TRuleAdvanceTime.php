<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Traits;

use Carbon\Carbon;
use DateInterval;
use Illuminate\Support\Str;
use Moves\Eloquent\Verifiable\Contracts\IVerifiable;
use Moves\Eloquent\Verifiable\Exceptions\VerificationRuleException;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;
use Moves\Eloquent\Verifiable\Rules\Calendar\Enums\AdvanceType;
use Moves\Eloquent\Verifiable\Rules\Calendar\Support\Formatter;

trait TRuleAdvanceTime
{
     /**
     * @param IVerifiableEvent $verifiable
     * @return bool
     * @throws \Exception
     */
    public function verify(IVerifiable $verifiable): bool
    {
        $configuredAdvanceMinutes = $this->getAdvanceMinutes();
        $now = Carbon::now();
        $actualAdvanceMinutes = $now->diffInMilliseconds($verifiable->getStartTime(), false) / 60000.0;

        if ($this->getAdvanceType()->equals(AdvanceType::MIN())
            ? $actualAdvanceMinutes < $configuredAdvanceMinutes
            : $actualAdvanceMinutes > abs($configuredAdvanceMinutes)
        )
        {
            $advanceType = $this->getAdvanceType();
            $interval = new DateInterval("PT{$configuredAdvanceMinutes}M");
            $humanReadableInterval = Formatter::formatInterval($interval);

            throw new VerificationRuleException(
                "This event can only be booked a {$advanceType} of {$humanReadableInterval} in advance.",
                $this
            );
        }

        return true;
    }
}
