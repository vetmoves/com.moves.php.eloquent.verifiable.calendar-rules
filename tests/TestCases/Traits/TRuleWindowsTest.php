<?php

namespace Tests\TestCases\Traits;

use Carbon\Carbon;
use Moves\Eloquent\Verifiable\Exceptions\VerificationRuleException;
use Moves\Eloquent\Verifiable\Rules\Calendar\Contracts\Verifiables\IVerifiableEvent;
use Moves\FowlerRecurringEvents\TemporalExpressions\TEDays;
use Tests\Models\Rules\TestRuleWindows;
use Tests\Models\Verifiables\TestVerifiableEvent;
use Tests\TestCases\TestCase;

class TRuleWindowsTest extends TestCase
{
    public function testWindowsNoBufferNoEvents()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            60
        );

        $windows = $rule->getAvailableWindowsForDate(Carbon::create('2021-01-01'));

        $this->assertCount(8, $windows);

        $this->assertEquals('2021-01-01 09:00:00', $windows[0]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 10:00:00', $windows[0]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 10:00:00', $windows[1]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 11:00:00', $windows[1]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 11:00:00', $windows[2]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 12:00:00', $windows[2]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 12:00:00', $windows[3]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 13:00:00', $windows[3]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 13:00:00', $windows[4]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 14:00:00', $windows[4]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 14:00:00', $windows[5]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 15:00:00', $windows[5]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 15:00:00', $windows[6]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 16:00:00', $windows[6]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 16:00:00', $windows[7]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 17:00:00', $windows[7]->getEndTime()->toDateTimeString());
    }

    public function testWindowsNoBufferNoEventsWithRecurrence()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            60,
            0,
            false,
            [],
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $windows = $rule->getAvailableWindowsForDate(Carbon::create('2021-01-02'));

        $this->assertCount(8, $windows);

        $this->assertEquals('2021-01-02 09:00:00', $windows[0]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 10:00:00', $windows[0]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 10:00:00', $windows[1]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 11:00:00', $windows[1]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 11:00:00', $windows[2]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 12:00:00', $windows[2]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 12:00:00', $windows[3]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 13:00:00', $windows[3]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 13:00:00', $windows[4]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 14:00:00', $windows[4]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 14:00:00', $windows[5]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 15:00:00', $windows[5]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 15:00:00', $windows[6]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 16:00:00', $windows[6]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 16:00:00', $windows[7]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 17:00:00', $windows[7]->getEndTime()->toDateTimeString());
    }

    public function testWindowsWithBufferNoEvents_BufferNotApplied()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            60,
            30
        );

        $windows = $rule->getAvailableWindowsForDate(Carbon::create('2021-01-01'));

        $this->assertCount(8, $windows);

        $this->assertEquals('2021-01-01 09:00:00', $windows[0]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 10:00:00', $windows[0]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 10:00:00', $windows[1]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 11:00:00', $windows[1]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 11:00:00', $windows[2]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 12:00:00', $windows[2]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 12:00:00', $windows[3]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 13:00:00', $windows[3]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 13:00:00', $windows[4]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 14:00:00', $windows[4]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 14:00:00', $windows[5]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 15:00:00', $windows[5]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 15:00:00', $windows[6]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 16:00:00', $windows[6]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 16:00:00', $windows[7]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 17:00:00', $windows[7]->getEndTime()->toDateTimeString());
    }

    public function testWindowsWithAlwaysBufferNoEvents_BufferIsApplied()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            60,
            30,
            true
        );

        $windows = $rule->getAvailableWindowsForDate(Carbon::create('2021-01-01'));

        $this->assertCount(5, $windows);

        $this->assertEquals('2021-01-01 09:00:00', $windows[0]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 10:00:00', $windows[0]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 10:30:00', $windows[1]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 11:30:00', $windows[1]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 12:00:00', $windows[2]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 13:00:00', $windows[2]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 13:30:00', $windows[3]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 14:30:00', $windows[3]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 15:00:00', $windows[4]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 16:00:00', $windows[4]->getEndTime()->toDateTimeString());
    }

    public function testWindowsWithBufferNoEventsWithRecurrence_BufferNotApplied()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            60,
            30,
            false,
            [],
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $windows = $rule->getAvailableWindowsForDate(Carbon::create('2021-01-02'));

        $this->assertCount(8, $windows);

        $this->assertEquals('2021-01-02 09:00:00', $windows[0]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 10:00:00', $windows[0]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 10:00:00', $windows[1]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 11:00:00', $windows[1]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 11:00:00', $windows[2]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 12:00:00', $windows[2]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 12:00:00', $windows[3]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 13:00:00', $windows[3]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 13:00:00', $windows[4]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 14:00:00', $windows[4]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 14:00:00', $windows[5]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 15:00:00', $windows[5]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 15:00:00', $windows[6]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 16:00:00', $windows[6]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 16:00:00', $windows[7]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 17:00:00', $windows[7]->getEndTime()->toDateTimeString());
    }

    public function testWindowsNoBufferWithEvents_WindowNotAddedAndBufferNotApplied()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            60,
            0,
            false,
            [
                new TestVerifiableEvent(
                    Carbon::create('2021-01-01 09:00:00'),
                    Carbon::create('2021-01-01 10:00:00')
                ),
                new TestVerifiableEvent(
                    Carbon::create('2021-01-01 12:00:00'),
                    Carbon::create('2021-01-01 13:00:00')
                )
            ]
        );

        $windows = $rule->getAvailableWindowsForDate(Carbon::create('2021-01-01'));

        $this->assertCount(6, $windows);

        $this->assertEquals('2021-01-01 10:00:00', $windows[0]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 11:00:00', $windows[0]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 11:00:00', $windows[1]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 12:00:00', $windows[1]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 13:00:00', $windows[2]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 14:00:00', $windows[2]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 14:00:00', $windows[3]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 15:00:00', $windows[3]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 15:00:00', $windows[4]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 16:00:00', $windows[4]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 16:00:00', $windows[5]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 17:00:00', $windows[5]->getEndTime()->toDateTimeString());
    }

    public function testWindowsNoBufferWithEventsWithRecurrence_WindowNotAddedAndBufferNotApplied()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            60,
            0,
            false,
            [
                new TestVerifiableEvent(
                    Carbon::create('2021-01-01 11:00:00'),
                    Carbon::create('2021-01-01 12:00:00')
                ),
                new TestVerifiableEvent(
                    Carbon::create('2021-01-01 13:00:00'),
                    Carbon::create('2021-01-01 14:00:00')
                ),
                new TestVerifiableEvent(
                    Carbon::create('2021-01-02 09:00:00'),
                    Carbon::create('2021-01-02 10:00:00')
                ),
                new TestVerifiableEvent(
                    Carbon::create('2021-01-02 12:00:00'),
                    Carbon::create('2021-01-02 13:00:00')
                )
            ],
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $windows = $rule->getAvailableWindowsForDate(Carbon::create('2021-01-02'));

        $this->assertCount(6, $windows);

        $this->assertEquals('2021-01-02 10:00:00', $windows[0]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 11:00:00', $windows[0]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 11:00:00', $windows[1]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 12:00:00', $windows[1]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 13:00:00', $windows[2]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 14:00:00', $windows[2]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 14:00:00', $windows[3]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 15:00:00', $windows[3]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 15:00:00', $windows[4]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 16:00:00', $windows[4]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 16:00:00', $windows[5]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 17:00:00', $windows[5]->getEndTime()->toDateTimeString());
    }

    public function testWindowsWithBufferWithEvents_WindowNotAddedAndBufferIsApplied()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            60,
            30,
            false,
            [
                new TestVerifiableEvent(
                    Carbon::create('2021-01-01 09:00:00'),
                    Carbon::create('2021-01-01 10:00:00')
                ),
                new TestVerifiableEvent(
                    Carbon::create('2021-01-01 12:30:00'),
                    Carbon::create('2021-01-01 13:30:00')
                )
            ]
        );

        $windows = $rule->getAvailableWindowsForDate(Carbon::create('2021-01-01'));

        $this->assertCount(4, $windows);

        $this->assertEquals('2021-01-01 10:30:00', $windows[0]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 11:30:00', $windows[0]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 14:00:00', $windows[1]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 15:00:00', $windows[1]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 15:00:00', $windows[2]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 16:00:00', $windows[2]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 16:00:00', $windows[3]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 17:00:00', $windows[3]->getEndTime()->toDateTimeString());
    }

    public function testWindowsWithAlwaysBufferWithEvents_WindowNotAddedAndBufferIsAlwaysApplied()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            60,
            30,
            true,
            [
                new TestVerifiableEvent(
                    Carbon::create('2021-01-01 09:00:00'),
                    Carbon::create('2021-01-01 10:00:00')
                ),
                new TestVerifiableEvent(
                    Carbon::create('2021-01-01 12:30:00'),
                    Carbon::create('2021-01-01 13:30:00')
                )
            ]
        );

        $windows = $rule->getAvailableWindowsForDate(Carbon::create('2021-01-01'));

        $this->assertCount(3, $windows);

        $this->assertEquals('2021-01-01 10:30:00', $windows[0]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 11:30:00', $windows[0]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 14:00:00', $windows[1]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 15:00:00', $windows[1]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 15:30:00', $windows[2]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 16:30:00', $windows[2]->getEndTime()->toDateTimeString());
    }

    public function testWindowsWithBufferWithEventsWithRecurrence_WindowNotAddedAndBufferIsApplied()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            60,
            30,
            false,
            [
                new TestVerifiableEvent(
                    Carbon::create('2021-01-01 10:00:00'),
                    Carbon::create('2021-01-01 11:00:00')
                ),
                new TestVerifiableEvent(
                    Carbon::create('2021-01-01 13:30:00'),
                    Carbon::create('2021-01-01 14:30:00')
                ),
                new TestVerifiableEvent(
                    Carbon::create('2021-01-02 09:00:00'),
                    Carbon::create('2021-01-02 10:00:00')
                ),
                new TestVerifiableEvent(
                    Carbon::create('2021-01-02 12:30:00'),
                    Carbon::create('2021-01-02 13:30:00')
                )
            ],
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $windows = $rule->getAvailableWindowsForDate(Carbon::create('2021-01-02'));

        $this->assertCount(4, $windows);

        $this->assertEquals('2021-01-02 10:30:00', $windows[0]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 11:30:00', $windows[0]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 14:00:00', $windows[1]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 15:00:00', $windows[1]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 15:00:00', $windows[2]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 16:00:00', $windows[2]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 16:00:00', $windows[3]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 17:00:00', $windows[3]->getEndTime()->toDateTimeString());
    }

    public function testWindowsWithOverlappingCloseTime_WindowNotAdded()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 16:30:00'),
            60
        );

        $windows = $rule->getAvailableWindowsForDate(Carbon::create('2021-01-01'));

        $this->assertCount(7, $windows);

        $this->assertEquals('2021-01-01 09:00:00', $windows[0]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 10:00:00', $windows[0]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 10:00:00', $windows[1]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 11:00:00', $windows[1]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 11:00:00', $windows[2]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 12:00:00', $windows[2]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 12:00:00', $windows[3]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 13:00:00', $windows[3]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 13:00:00', $windows[4]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 14:00:00', $windows[4]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 14:00:00', $windows[5]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 15:00:00', $windows[5]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-01 15:00:00', $windows[6]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-01 16:00:00', $windows[6]->getEndTime()->toDateTimeString());
    }

    public function testWindowsWithOverlappingCloseTimeWithRecurrence_WindowNotAdded()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 16:30:00'),
            60,
            0,
            false,
            [],
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $windows = $rule->getAvailableWindowsForDate(Carbon::create('2021-01-02'));

        $this->assertCount(7, $windows);

        $this->assertEquals('2021-01-02 09:00:00', $windows[0]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 10:00:00', $windows[0]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 10:00:00', $windows[1]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 11:00:00', $windows[1]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 11:00:00', $windows[2]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 12:00:00', $windows[2]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 12:00:00', $windows[3]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 13:00:00', $windows[3]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 13:00:00', $windows[4]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 14:00:00', $windows[4]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 14:00:00', $windows[5]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 15:00:00', $windows[5]->getEndTime()->toDateTimeString());

        $this->assertEquals('2021-01-02 15:00:00', $windows[6]->getStartTime()->toDateTimeString());
        $this->assertEquals('2021-01-02 16:00:00', $windows[6]->getEndTime()->toDateTimeString());
    }

    public function testDateOutsideRecurrence_NoWindowsAdded()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 16:30:00'),
            60,
            0,
            false,
            [],
            TEDays::build(Carbon::create('2021-01-01'))->setFrequency(2)
        );

        $windows = $rule->getAvailableWindowsForDate(Carbon::create('2021-01-02'));

        $this->assertCount(0, $windows);
    }

    public function testEventMatchesValidWindow_Passes()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            60
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 10:00:00'),
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testEventMatchesValidWindowWithRecurrence_Passes()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            60,
            0,
            false,
            [],
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-02 09:00:00'),
            Carbon::create('2021-01-02 10:00:00'),
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testEventNoMatchValidWindow_Fails()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            60,
            0,
            false,
            [],
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-02 09:30:00'),
            Carbon::create('2021-01-02 10:30:00'),
        );

        $this->expectException(VerificationRuleException::class);
        $this->expectExceptionMessage(
            'This event must be booked during one of the pre-configured availability windows.'
        );

        $rule->verify($event);
    }

    public function testGetWindowsForDateWithTzShift()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 00:00:00')
                ->shiftTimezone('America/Los_Angeles')
                ->setTimezone('UTC'),
            Carbon::create('2021-01-02 00:00:00')
                ->shiftTimezone('America/Los_Angeles')
                ->setTimezone('UTC'),
            60,
            0,
            false,
            [],
            TEDays::build(Carbon::create('2020-12-31'))
        );

        $windows = $rule->getAvailableWindowsForDate(Carbon::create('2021-01-01 00:00:00')->shiftTimezone('America/Los_Angeles'));

        $this->assertCount(24, $windows);

        $this->assertEquals('2021-01-01 00:00:00', $windows[0]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-01 01:00:00', $windows[0]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());

        $this->assertEquals('2021-01-01 01:00:00', $windows[1]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-01 02:00:00', $windows[1]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());

        $this->assertEquals('2021-01-01 02:00:00', $windows[2]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-01 03:00:00', $windows[2]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());

        $this->assertEquals('2021-01-01 03:00:00', $windows[3]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-01 04:00:00', $windows[3]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());

        $this->assertEquals('2021-01-01 04:00:00', $windows[4]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-01 05:00:00', $windows[4]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());

        $this->assertEquals('2021-01-01 05:00:00', $windows[5]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-01 06:00:00', $windows[5]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());

        $this->assertEquals('2021-01-01 06:00:00', $windows[6]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-01 07:00:00', $windows[6]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());

        $this->assertEquals('2021-01-01 07:00:00', $windows[7]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-01 08:00:00', $windows[7]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());

        $this->assertEquals('2021-01-01 08:00:00', $windows[8]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-01 09:00:00', $windows[8]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());

        $this->assertEquals('2021-01-01 09:00:00', $windows[9]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-01 10:00:00', $windows[9]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());

        $this->assertEquals('2021-01-01 10:00:00', $windows[10]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-01 11:00:00', $windows[10]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());

        $this->assertEquals('2021-01-01 11:00:00', $windows[11]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-01 12:00:00', $windows[11]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());

        $this->assertEquals('2021-01-01 12:00:00', $windows[12]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-01 13:00:00', $windows[12]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());

        $this->assertEquals('2021-01-01 13:00:00', $windows[13]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-01 14:00:00', $windows[13]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());

        $this->assertEquals('2021-01-01 14:00:00', $windows[14]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-01 15:00:00', $windows[14]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());

        $this->assertEquals('2021-01-01 15:00:00', $windows[15]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-01 16:00:00', $windows[15]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());

        $this->assertEquals('2021-01-01 16:00:00', $windows[16]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-01 17:00:00', $windows[16]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());

        $this->assertEquals('2021-01-01 17:00:00', $windows[17]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-01 18:00:00', $windows[17]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());

        $this->assertEquals('2021-01-01 18:00:00', $windows[18]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-01 19:00:00', $windows[18]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());

        $this->assertEquals('2021-01-01 19:00:00', $windows[19]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-01 20:00:00', $windows[19]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());

        $this->assertEquals('2021-01-01 20:00:00', $windows[20]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-01 21:00:00', $windows[20]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());

        $this->assertEquals('2021-01-01 21:00:00', $windows[21]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-01 22:00:00', $windows[21]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());

        $this->assertEquals('2021-01-01 22:00:00', $windows[22]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-01 23:00:00', $windows[22]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());

        $this->assertEquals('2021-01-01 23:00:00', $windows[23]->getStartTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
        $this->assertEquals('2021-01-02 00:00:00', $windows[23]->getEndTime()->setTimezone('America/Los_Angeles')->toDateTimeString());
    }
}
