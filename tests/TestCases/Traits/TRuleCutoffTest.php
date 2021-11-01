<?php

namespace Tests\TestCases\Traits;

use Carbon\Carbon;
use Moves\Eloquent\Verifiable\Exceptions\VerificationRuleException;
use Moves\Eloquent\Verifiable\Rules\Calendar\Enums\CutoffPeriod;
use Moves\Eloquent\Verifiable\Rules\Calendar\Enums\CutoffType;
use Tests\Models\Rules\TestRuleCutoff;
use Tests\Models\Verifiables\TestVerifiableEvent;
use Tests\TestCases\TestCase;

class TRuleCutoffTest extends TestCase
{
    public function testDateBeforeDisallowCutoffPasses()
    {
        $minutesToTomorrow = Carbon::now()->diffInMinutes(Carbon::tomorrow());

        $rule = new TestRuleCutoff(
            CutoffType::DISALLOW(),
            CutoffPeriod::DAY(),
            $minutesToTomorrow - 10
        );

        $event = new TestVerifiableEvent(
            Carbon::tomorrow()->addHour(),
            Carbon::tomorrow()->addHours(2)
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testDateUpToDisallowCutoffPasses()
    {
        $minutesToTomorrow = Carbon::now()->diffInMinutes(Carbon::tomorrow());

        $rule = new TestRuleCutoff(
            CutoffType::DISALLOW(),
            CutoffPeriod::DAY(),
            $minutesToTomorrow
        );

        $event = new TestVerifiableEvent(
            Carbon::tomorrow()->addHour(),
            Carbon::tomorrow()->addHours(2)
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testDateJustAfterDisallowCutoffFails()
    {
        $minutesToTomorrow = Carbon::now()->diffInMinutes(Carbon::tomorrow());

        $cutoffOffsetMinutes = $minutesToTomorrow + 1;

        $cutoffTime = Carbon::tomorrow()->subMinutes($cutoffOffsetMinutes);

        $rule = new TestRuleCutoff(
            CutoffType::DISALLOW(),
            CutoffPeriod::DAY(),
            $cutoffOffsetMinutes
        );

        $event = new TestVerifiableEvent(
            Carbon::tomorrow()->addHour(),
            Carbon::tomorrow()->addHours(2)
        );

        $this->expectException(VerificationRuleException::class);
        $this->expectExceptionMessage(
            'Booking for this event closed at ' . $cutoffTime->format('M j, Y g:i A') . '.'
        );

        $rule->verify($event);
    }

    public function testDateAfterDisallowCutoffFails()
    {
        $minutesToTomorrow = Carbon::now()->diffInMinutes(Carbon::tomorrow());

        $cutoffOffsetMinutes = $minutesToTomorrow + 10;

        $cutoffTime = Carbon::tomorrow()->subMinutes($cutoffOffsetMinutes);

        $rule = new TestRuleCutoff(
            CutoffType::DISALLOW(),
            CutoffPeriod::DAY(),
            $cutoffOffsetMinutes
        );

        $event = new TestVerifiableEvent(
            Carbon::tomorrow()->addHour(),
            Carbon::tomorrow()->addHours(2)
        );

        $this->expectException(VerificationRuleException::class);
        $this->expectExceptionMessage(
            'Booking for this event closed at ' . $cutoffTime->format('M j, Y g:i A') . '.'
        );

        $rule->verify($event);
    }

    public function testDateBeforeAllowCutoffFails()
    {
        $minutesToTomorrow = Carbon::now()->diffInMinutes(Carbon::tomorrow());

        $cutoffOffsetMinutes = $minutesToTomorrow - 10;

        $cutoffTime = Carbon::tomorrow()->subMinutes($cutoffOffsetMinutes);

        $rule = new TestRuleCutoff(
            CutoffType::ALLOW(),
            CutoffPeriod::DAY(),
            $cutoffOffsetMinutes
        );

        $event = new TestVerifiableEvent(
            Carbon::tomorrow()->addHour(),
            Carbon::tomorrow()->addHours(2)
        );

        $this->expectException(VerificationRuleException::class);
        $this->expectExceptionMessage(
            'This event cannot be booked until ' . $cutoffTime->format('M j, Y g:i A') . '.'
        );

        $rule->verify($event);
    }

    public function testDateUpToAllowCutoffFails()
    {
        $minutesToTomorrow = Carbon::now()->diffInMinutes(Carbon::tomorrow());

        $cutoffTime = Carbon::tomorrow()->subMinutes($minutesToTomorrow);

        $rule = new TestRuleCutoff(
            CutoffType::ALLOW(),
            CutoffPeriod::DAY(),
            $minutesToTomorrow
        );

        $event = new TestVerifiableEvent(
            Carbon::tomorrow()->addHour(),
            Carbon::tomorrow()->addHours(2)
        );

        $this->expectException(VerificationRuleException::class);
        $this->expectExceptionMessage(
            'This event cannot be booked until ' . $cutoffTime->format('M j, Y g:i A') . '.'
        );

        $rule->verify($event);
    }

    public function testDateJustAfterAllowCutoffPasses()
    {
        $minutesToTomorrow = Carbon::now()->diffInMinutes(Carbon::tomorrow());

        $rule = new TestRuleCutoff(
            CutoffType::ALLOW(),
            CutoffPeriod::DAY(),
            $minutesToTomorrow + 1
        );

        $event = new TestVerifiableEvent(
            Carbon::tomorrow()->addHour(),
            Carbon::tomorrow()->addHours(2)
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testDateAfterAllowCutoffPasses()
    {
        $minutesToTomorrow = Carbon::now()->diffInMinutes(Carbon::tomorrow());

        $rule = new TestRuleCutoff(
            CutoffType::ALLOW(),
            CutoffPeriod::DAY(),
            $minutesToTomorrow + 10
        );

        $event = new TestVerifiableEvent(
            Carbon::tomorrow()->addHour(),
            Carbon::tomorrow()->addHours(2)
        );

        $this->assertTrue($rule->verify($event));
    }
}
