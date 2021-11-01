<?php

namespace Tests\TestCases\Traits;

use Carbon\Carbon;
use Moves\Eloquent\Verifiable\Exceptions\VerificationRuleException;
use Moves\Eloquent\Verifiable\Rules\Calendar\Enums\AdvanceType;
use Tests\Models\Rules\TestRuleAdvanceTime;
use Tests\Models\Verifiables\TestVerifiableEvent;
use Tests\TestCases\TestCase;

class TRuleAdvanceTimeTest extends TestCase
{
    public function testLessThanMaxAdvancePasses()
    {
        $rule = new TestRuleAdvanceTime(AdvanceType::MAX(), 60);

        $event = new TestVerifiableEvent(
            Carbon::now(),
            Carbon::now()->addHour()
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testUpToMaxAdvancePasses()
    {
        $rule = new TestRuleAdvanceTime(AdvanceType::MAX(), 60);

        $event = new TestVerifiableEvent(
            Carbon::now()->addMinutes(60),
            Carbon::now()->addMinutes(120)
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testJustPastMaxAdvanceFails()
    {
        $rule = new TestRuleAdvanceTime(AdvanceType::MAX(), 60);

        $event = new TestVerifiableEvent(
            Carbon::now()->addMinutes(60)->addSeconds(1),
            Carbon::now()->addMinutes(120)
        );

        $this->expectException(VerificationRuleException::class);
        $this->expectExceptionMessage(
            'This event must be booked less than 60 minutes in advance.'
        );

        $rule->verify($event);
    }

    public function testGreaterThanMaxFails()
    {
        $rule = new TestRuleAdvanceTime(AdvanceType::MAX(), 60);

        $event = new TestVerifiableEvent(
            Carbon::now()->addMinutes(120),
            Carbon::now()->addMinutes(180)
        );

        $this->expectException(VerificationRuleException::class);
        $this->expectExceptionMessage(
            'This event must be booked less than 60 minutes in advance.'
        );

        $rule->verify($event);
    }

    public function testGreaterThanMinAdvancePasses()
    {
        $rule = new TestRuleAdvanceTime(AdvanceType::MIN(), 60);

        $event = new TestVerifiableEvent(
            Carbon::now()->addHours(2),
            Carbon::now()->addHours(3)
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testUpToMinAdvancePasses()
    {
        $rule = new TestRuleAdvanceTime(AdvanceType::MIN(), 60);

        $event = new TestVerifiableEvent(
            Carbon::now()->addHour()->addSecond(),
            Carbon::now()->addHours(2)
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testJustLessThanMinAdvanceFails()
    {
        $rule = new TestRuleAdvanceTime(AdvanceType::MIN(), 60);

        $event = new TestVerifiableEvent(
            Carbon::now()->addHour()->subSecond(),
            Carbon::now()->addHours(2)
        );

        $this->expectException(VerificationRuleException::class);
        $this->expectExceptionMessage(
            'This event must be booked at least 60 minutes in advance.'
        );

        $rule->verify($event);
    }

    public function testLessThanMinAdvanceFails()
    {
        $rule = new TestRuleAdvanceTime(AdvanceType::MIN(), 60);

        $event = new TestVerifiableEvent(
            Carbon::now()->addMinutes(30),
            Carbon::now()->addMinutes(90)
        );

        $this->expectException(VerificationRuleException::class);
        $this->expectExceptionMessage(
            'This event must be booked at least 60 minutes in advance.'
        );

        $rule->verify($event);
    }
}
