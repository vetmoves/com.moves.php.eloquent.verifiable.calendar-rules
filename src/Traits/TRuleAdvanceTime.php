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
    public function getMinBookableDate(): Carbon
    {
        if ($this->getAdvanceType()->equals(AdvanceType::MIN())) {
            return Carbon::now()->addMinutes($this->getAdvanceMinutes());
        } else {
            return Carbon::today();
        }
    }

    public function getMaxBookableDate(): ?Carbon
    {
        if ($this->getAdvanceType()->equals(AdvanceType::MIN())) {
            return null;
        } else {
            return Carbon::now()->addMinutes($this->getAdvanceMinutes());
        }
    }

     /**
     * @param IVerifiableEvent $verifiable
     * @return bool
     * @throws \Exception
     */
    public function verify(IVerifiable $verifiable): bool
    {
        $now = Carbon::now();

        $configuredAdvanceMinutes = $this->getAdvanceMinutes($verifiable);
        $actualAdvanceMinutes = $now->diffInMilliseconds($verifiable->getStartTime(), false) / 60000.0;

        $configuredInterval = $now->diff($now->copy()->addMinutes($configuredAdvanceMinutes));
        $fmtConfiguredInterval = Formatter::formatInterval($configuredInterval);

        $actualInterval = $now->diff($verifiable->getStartTime());
        $fmtActualInterval = Formatter::formatInterval($actualInterval);

        if ($this->getAdvanceType($verifiable)->equals(AdvanceType::MIN())
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
            $this->getAdvanceType($verifiable)->equals(AdvanceType::MAX())
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
