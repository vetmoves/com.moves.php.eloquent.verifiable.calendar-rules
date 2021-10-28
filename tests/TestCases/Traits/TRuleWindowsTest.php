<?php

namespace Tests\TestCases\Traits;

use Carbon\Carbon;
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

        $this->assertEquals('2021-01-01 09:00:00', $windows[0]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 10:00:00', $windows[0]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 10:00:00', $windows[1]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 11:00:00', $windows[1]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 11:00:00', $windows[2]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 12:00:00', $windows[2]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 12:00:00', $windows[3]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 13:00:00', $windows[3]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 13:00:00', $windows[4]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 14:00:00', $windows[4]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 14:00:00', $windows[5]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 15:00:00', $windows[5]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 15:00:00', $windows[6]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 16:00:00', $windows[6]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 16:00:00', $windows[7]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 17:00:00', $windows[7]->getEnd()->toDateTimeString());
    }

    public function testWindowsNoBufferNoEventsWithRecurrence()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            60,
            0,
            [],
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $windows = $rule->getAvailableWindowsForDate(Carbon::create('2021-01-02'));

        $this->assertCount(8, $windows);

        $this->assertEquals('2021-01-02 09:00:00', $windows[0]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 10:00:00', $windows[0]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 10:00:00', $windows[1]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 11:00:00', $windows[1]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 11:00:00', $windows[2]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 12:00:00', $windows[2]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 12:00:00', $windows[3]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 13:00:00', $windows[3]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 13:00:00', $windows[4]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 14:00:00', $windows[4]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 14:00:00', $windows[5]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 15:00:00', $windows[5]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 15:00:00', $windows[6]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 16:00:00', $windows[6]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 16:00:00', $windows[7]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 17:00:00', $windows[7]->getEnd()->toDateTimeString());
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

        $this->assertEquals('2021-01-01 09:00:00', $windows[0]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 10:00:00', $windows[0]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 10:00:00', $windows[1]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 11:00:00', $windows[1]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 11:00:00', $windows[2]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 12:00:00', $windows[2]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 12:00:00', $windows[3]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 13:00:00', $windows[3]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 13:00:00', $windows[4]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 14:00:00', $windows[4]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 14:00:00', $windows[5]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 15:00:00', $windows[5]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 15:00:00', $windows[6]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 16:00:00', $windows[6]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 16:00:00', $windows[7]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 17:00:00', $windows[7]->getEnd()->toDateTimeString());
    }

    public function testWindowsWithBufferNoEventsWithRecurrence_BufferNotApplied()
    {

        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            60,
            30,
            [],
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $windows = $rule->getAvailableWindowsForDate(Carbon::create('2021-01-02'));

        $this->assertCount(8, $windows);

        $this->assertEquals('2021-01-02 09:00:00', $windows[0]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 10:00:00', $windows[0]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 10:00:00', $windows[1]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 11:00:00', $windows[1]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 11:00:00', $windows[2]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 12:00:00', $windows[2]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 12:00:00', $windows[3]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 13:00:00', $windows[3]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 13:00:00', $windows[4]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 14:00:00', $windows[4]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 14:00:00', $windows[5]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 15:00:00', $windows[5]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 15:00:00', $windows[6]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 16:00:00', $windows[6]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 16:00:00', $windows[7]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 17:00:00', $windows[7]->getEnd()->toDateTimeString());
    }

    public function testWindowsNoBufferWithEvents_WindowNotAddedAndBufferNotApplied()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            60,
            0,
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

        $this->assertEquals('2021-01-01 10:00:00', $windows[0]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 11:00:00', $windows[0]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 11:00:00', $windows[1]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 12:00:00', $windows[1]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 13:00:00', $windows[2]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 14:00:00', $windows[2]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 14:00:00', $windows[3]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 15:00:00', $windows[3]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 15:00:00', $windows[4]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 16:00:00', $windows[4]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 16:00:00', $windows[5]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 17:00:00', $windows[5]->getEnd()->toDateTimeString());
    }

    public function testWindowsNoBufferWithEventsWithRecurrence_WindowNotAddedAndBufferNotApplied()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            60,
            0,
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

        $this->assertEquals('2021-01-02 10:00:00', $windows[0]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 11:00:00', $windows[0]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 11:00:00', $windows[1]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 12:00:00', $windows[1]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 13:00:00', $windows[2]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 14:00:00', $windows[2]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 14:00:00', $windows[3]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 15:00:00', $windows[3]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 15:00:00', $windows[4]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 16:00:00', $windows[4]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 16:00:00', $windows[5]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 17:00:00', $windows[5]->getEnd()->toDateTimeString());
    }

    public function testWindowsWithBufferWithEvents_WindowNotAddedAndBufferIsApplied()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            60,
            30,
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

        $this->assertEquals('2021-01-01 10:30:00', $windows[0]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 11:30:00', $windows[0]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 14:00:00', $windows[1]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 15:00:00', $windows[1]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 15:00:00', $windows[2]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 16:00:00', $windows[2]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 16:00:00', $windows[3]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 17:00:00', $windows[3]->getEnd()->toDateTimeString());
    }

    public function testWindowsWithBufferWithEventsWithRecurrence_WindowNotAddedAndBufferIsApplied()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            60,
            30,
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

        $this->assertEquals('2021-01-02 10:30:00', $windows[0]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 11:30:00', $windows[0]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 14:00:00', $windows[1]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 15:00:00', $windows[1]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 15:00:00', $windows[2]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 16:00:00', $windows[2]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 16:00:00', $windows[3]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 17:00:00', $windows[3]->getEnd()->toDateTimeString());
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

        $this->assertEquals('2021-01-01 09:00:00', $windows[0]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 10:00:00', $windows[0]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 10:00:00', $windows[1]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 11:00:00', $windows[1]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 11:00:00', $windows[2]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 12:00:00', $windows[2]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 12:00:00', $windows[3]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 13:00:00', $windows[3]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 13:00:00', $windows[4]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 14:00:00', $windows[4]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 14:00:00', $windows[5]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 15:00:00', $windows[5]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-01 15:00:00', $windows[6]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-01 16:00:00', $windows[6]->getEnd()->toDateTimeString());
    }

    public function testWindowsWithOverlappingCloseTimeWithRecurrence_WindowNotAdded()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 16:30:00'),
            60,
            0,
            [],
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $windows = $rule->getAvailableWindowsForDate(Carbon::create('2021-01-02'));

        $this->assertCount(7, $windows);

        $this->assertEquals('2021-01-02 09:00:00', $windows[0]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 10:00:00', $windows[0]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 10:00:00', $windows[1]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 11:00:00', $windows[1]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 11:00:00', $windows[2]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 12:00:00', $windows[2]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 12:00:00', $windows[3]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 13:00:00', $windows[3]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 13:00:00', $windows[4]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 14:00:00', $windows[4]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 14:00:00', $windows[5]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 15:00:00', $windows[5]->getEnd()->toDateTimeString());

        $this->assertEquals('2021-01-02 15:00:00', $windows[6]->getStart()->toDateTimeString());
        $this->assertEquals('2021-01-02 16:00:00', $windows[6]->getEnd()->toDateTimeString());
    }

    public function testDateOutsideRecurrence_NoWindowsAdded()
    {
        $rule = new TestRuleWindows(
            Carbon::create('2021-01-01 09:00:00'),
            Carbon::create('2021-01-01 16:30:00'),
            60,
            0,
            [],
            TEDays::build(Carbon::create('2021-01-01'))->setFrequency(2)
        );

        $windows = $rule->getAvailableWindowsForDate(Carbon::create('2021-01-02'));

        $this->assertCount(0, $windows);
    }
}
