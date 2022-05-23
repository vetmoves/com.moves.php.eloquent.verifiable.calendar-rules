<?php

namespace Tests\TestCases\Traits;

use Carbon\Carbon;
use Moves\Eloquent\Verifiable\Exceptions\VerificationRuleException;
use Moves\Eloquent\Verifiable\Rules\Calendar\Enums\CutoffPeriod;
use Moves\Eloquent\Verifiable\Rules\Calendar\Enums\CutoffType;
use Moves\FowlerRecurringEvents\TemporalExpressions\TEDays;
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
            'Booking for this event closed at'
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
            'Booking for this event closed at'
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
            'This event cannot be booked until'
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
            'This event cannot be booked until'
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

    public function testInterpretRecurrencePatternWeek()
    {
        $rule = new TestRuleCutoff(
            CutoffType::ALLOW(),
            CutoffPeriod::WEEK(),
            30
        );

        $pattern = $rule->interpretRecurrencePattern(Carbon::tomorrow()->addHour());

        $this->assertInstanceOf(TEDays::class, $pattern);
        $this->assertEquals(7, $pattern->getFrequency());

        $lastSunday = Carbon::tomorrow()
            ->subDays(Carbon::tomorrow()->dayOfWeek % 7);

        $this->assertEquals($lastSunday, $pattern->getStart());
        $this->assertEquals($lastSunday, $pattern->next());
    }

    public function testInterpretRecurrencePatternDay()
    {
        $rule = new TestRuleCutoff(
            CutoffType::ALLOW(),
            CutoffPeriod::DAY(),
            30
        );

        $pattern = $rule->interpretRecurrencePattern(Carbon::tomorrow()->addHour());

        $this->assertInstanceOf(TEDays::class, $pattern);
        $this->assertEquals(1, $pattern->getFrequency());
        $this->assertEquals(Carbon::tomorrow(), $pattern->getStart());
        $this->assertEquals(Carbon::tomorrow(), $pattern->next());
    }

    public function testGetMinBookableDateWeekAllow()
    {
        $rule = new TestRuleCutoff(
            CutoffType::ALLOW(),
            CutoffPeriod::WEEK(),
            0
        );

        $this->assertEquals(Carbon::today(), $rule->getMinBookableDate());
    }

    public function testGetMinBookableDateWeekDisallow()
    {
        $rule = new TestRuleCutoff(
            CutoffType::DISALLOW(),
            CutoffPeriod::WEEK(),
            0
        );

        $nextSunday = Carbon::tomorrow()
            ->subDays(Carbon::tomorrow()->dayOfWeek % 7)
            ->addWeek();

        $this->assertEquals($nextSunday, $rule->getMinBookableDate());
    }

    public function testGetMinBookableDateDayAllow()
    {
        $rule = new TestRuleCutoff(
            CutoffType::ALLOW(),
            CutoffPeriod::DAY(),
            0
        );

        $this->assertEquals(Carbon::today(), $rule->getMinBookableDate());
    }

    public function testGetMinBookableDateDayDisallow()
    {
        $rule = new TestRuleCutoff(
            CutoffType::DISALLOW(),
            CutoffPeriod::DAY(),
            0
        );

        $this->assertEquals(Carbon::tomorrow(), $rule->getMinBookableDate());
    }

    public function testGetMaxBookableDateWeekAllow()
    {
        $rule = new TestRuleCutoff(
            CutoffType::ALLOW(),
            CutoffPeriod::WEEK(),
            0
        );

        $nextSunday = Carbon::tomorrow()
            ->subDays(Carbon::tomorrow()->dayOfWeek % 7)
            ->addWeek();

        $this->assertEquals($nextSunday, $rule->getMaxBookableDate());
    }

    public function testGetMaxBookableDateWeekDisallow()
    {
        $rule = new TestRuleCutoff(
            CutoffType::DISALLOW(),
            CutoffPeriod::WEEK(),
            0
        );

        $this->assertNull($rule->getMaxBookableDate());
    }

    public function testGetMaxBookableDateDayAllow()
    {
        $rule = new TestRuleCutoff(
            CutoffType::ALLOW(),
            CutoffPeriod::DAY(),
            0
        );

        $this->assertEquals(Carbon::tomorrow(), $rule->getMaxBookableDate());
    }

    public function testGetMaxBookableDateDayDisallow()
    {
        $rule = new TestRuleCutoff(
            CutoffType::DISALLOW(),
            CutoffPeriod::DAY(),
            0
        );

        $this->assertNull($rule->getMaxBookableDate());
    }
}
