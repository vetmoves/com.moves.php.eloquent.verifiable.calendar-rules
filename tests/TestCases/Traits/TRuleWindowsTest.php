<?php

namespace Tests\TestCases\Traits;

use Carbon\Carbon;
use Moves\Eloquent\Verifiable\Exceptions\VerificationRuleException;
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

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 10:00:00'),
            Carbon::create('2021-01-01 11:00:00')
        );

        $windows = $rule->getAvailableWindowsForDate($event, Carbon::create('2021-01-01'));

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

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 10:00:00'),
            Carbon::create('2021-01-01 11:00:00')
        );

        $windows = $rule->getAvailableWindowsForDate($event, Carbon::create('2021-01-02'));

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

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 10:00:00'),
            Carbon::create('2021-01-01 11:00:00')
        );

        $windows = $rule->getAvailableWindowsForDate($event, Carbon::create('2021-01-01'));

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

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 10:00:00'),
            Carbon::create('2021-01-01 11:00:00')
        );

        $windows = $rule->getAvailableWindowsForDate($event, Carbon::create('2021-01-01'));

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

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 10:00:00'),
            Carbon::create('2021-01-01 11:00:00')
        );

        $windows = $rule->getAvailableWindowsForDate($event, Carbon::create('2021-01-02'));

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

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 10:00:00'),
            Carbon::create('2021-01-01 11:00:00')
        );

        $windows = $rule->getAvailableWindowsForDate($event, Carbon::create('2021-01-01'));

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

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 11:00:00'),
            Carbon::create('2021-01-01 12:00:00')
        );

        $windows = $rule->getAvailableWindowsForDate($event, Carbon::create('2021-01-02'));

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

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 10:00:00')
        );

        $windows = $rule->getAvailableWindowsForDate($event, Carbon::create('2021-01-01'));

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

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 10:00:00')
        );

        $windows = $rule->getAvailableWindowsForDate($event, Carbon::create('2021-01-01'));

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

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 10:00:00'),
            Carbon::create('2021-01-01 11:00:00')
        );

        $windows = $rule->getAvailableWindowsForDate($event, Carbon::create('2021-01-02'));

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

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 10:00:00'),
            Carbon::create('2021-01-01 11:00:00')
        );

        $windows = $rule->getAvailableWindowsForDate($event, Carbon::create('2021-01-01'));

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

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 10:00:00'),
            Carbon::create('2021-01-01 11:00:00')
        );

        $windows = $rule->getAvailableWindowsForDate($event, Carbon::create('2021-01-02'));

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

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 10:00:00'),
            Carbon::create('2021-01-01 11:00:00')
        );

        $windows = $rule->getAvailableWindowsForDate($event, Carbon::create('2021-01-02'));

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
}
