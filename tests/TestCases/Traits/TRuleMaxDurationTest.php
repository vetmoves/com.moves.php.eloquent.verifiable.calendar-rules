<?php

namespace Tests\TestCases\Traits;

use Carbon\Carbon;
use Moves\Eloquent\Verifiable\Exceptions\VerifiableConfigurationException;
use Moves\Eloquent\Verifiable\Exceptions\VerificationRuleException;
use Tests\Models\Rules\TestRuleMaxDuration;
use Tests\Models\Verifiables\TestVerifiableEvent;
use Tests\TestCases\TestCase;

class TRuleMaxDurationTest extends TestCase
{
    public function testLessThanMaxDurationPasses()
    {
        $rule = new TestRuleMaxDuration(60);

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 08:15:00')
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testUpToMaxDurationPasses()
    {
        $rule = new TestRuleMaxDuration(60);

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 09:00:00')
        );
        $this->assertTrue($rule->verify($event));
    }

    public function testNegativeDurationFails()
    {
        $rule = new TestRuleMaxDuration(60);

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 08:15:00'),
            Carbon::create('2021-01-01 08:00:00')
        );

        $this->expectException(VerifiableConfigurationException::class);

        $rule->verify($event);
    }

    public function testGreaterThanMaxDurationFails()
    {
        $rule = new TestRuleMaxDuration(60);

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 09:01:00')
        );

        $this->expectException(VerificationRuleException::class);

        $rule->verify($event);
    }
}
