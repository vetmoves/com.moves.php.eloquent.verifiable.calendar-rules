<?php

namespace Moves\Eloquent\Verifiable\Rules\Calendar\Traits;

use Carbon\Carbon;
use DateInterval;
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

        $configuredInterval = new DateInterval("PT{$configuredAdvanceMinutes}M");
        $fmtConfiguredInterval = Formatter::formatInterval($configuredInterval);

        $actualInterval = new DateInterval('PT' . intval($actualAdvanceMinutes) . 'M');
        $fmtActualInterval = Formatter::formatInterval($actualInterval);

        if ($this->getAdvanceType()->equals(AdvanceType::MIN())
            && $actualAdvanceMinutes < $configuredAdvanceMinutes
        )
        {
            throw new VerificationRuleException(
                __('verifiable_calendar_rules::messages.advance.min', [
                    'expected' => $fmtConfiguredInterval,
                    'actual' => $fmtActualInterval
                ]),
                $this
            );
        }

        if (
            $this->getAdvanceType()->equals(AdvanceType::MAX())
            && $actualAdvanceMinutes > abs($configuredAdvanceMinutes)
        )
        {
            throw new VerificationRuleException(
                __('verifiable_calendar_rules::messages.advance.max', [
                    'expected' => $fmtConfiguredInterval,
                    'actual' => $fmtActualInterval
                ]),
                $this
            );
        }

        return true;
    }
}
