<?php

namespace Tests\TestCases\Traits;

use Carbon\Carbon;
use Moves\FowlerRecurringEvents\TemporalExpressions\TEDays;
use Tests\Models\Rules\TestRuleClosure;
use Tests\Models\Verifiables\TestVerifiableEvent;
use Tests\TestCases\TestCase;

class TRuleClosureTest extends TestCase
{
    public function testEndAfterStartOnSameDayEnforced()
    {
        $rule = new TestRuleClosure(
            Carbon::create('2021-01-01 13:00:00'),
            Carbon::create('2021-01-01 12:00:00')
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 10:00:00'),
            Carbon::create('2021-01-01 11:00:00')
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);

        $rule = new TestRuleClosure(
            Carbon::create('2021-01-01 13:00:00'),
            Carbon::create('2021-01-02 12:00:00')
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 10:00:00'),
            Carbon::create('2021-01-01 11:00:00')
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    public function testDuringClosureFails()
    {
        $rule = new TestRuleClosure(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00')
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 12:15:00'),
            Carbon::create('2021-01-01 12:45:00')
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);

    }

    public function testEventWithEndBeforeStartFails()
    {
        $rule = new TestRuleClosure(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 17:00:00')
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 11:00:00'),
            Carbon::create('2021-01-01 10:00:00')
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    public function testEventDuringClosureWithRecurrencePasses()
    {
        $rule = new TestRuleClosure(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00'),
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-02 12:15:00'),
            Carbon::create('2021-01-02 12:45:00')
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    public function testEventDuringClosureWithIncorrectRecurrencePasses()
    {
        $rule = new TestRuleClosure(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00'),
            TEDays::build(Carbon::create('2021-01-01'))->setFrequency(2)
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-02 12:15:00'),
            Carbon::create('2021-01-02 12:45:00')
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testEventAtStartOfClosureFails()
    {
        $rule = new TestRuleClosure(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00')
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 12:15:00')
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    public function testEventAtStartOfClosureWithRecurrencePasses()
    {
        $rule = new TestRuleClosure(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00'),
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-02 12:00:00'),
            Carbon::create('2021-01-02 12:15:00')
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    public function testEventBeforeClosurePasses()
    {
        $rule = new TestRuleClosure(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00')
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 11:00:00'),
            Carbon::create('2021-01-01 12:00:00')
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testEventBeforeClosureWithRecurrencePasses()
    {
        $rule = new TestRuleClosure(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00'),
            TEDays::build(Carbon::create('2021-01-01'))

        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-02 11:00:00'),
            Carbon::create('2021-01-02 12:00:00')
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testEventOverlappingClosureStartFails()
    {
        $rule = new TestRuleClosure(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00')
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 11:30:00'),
            Carbon::create('2021-01-01 12:30:00')
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    public function testEventOverlappingClosureStartWithRecurrenceFails()
    {
        $rule = new TestRuleClosure(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00'),
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-02 11:30:00'),
            Carbon::create('2021-01-02 12:30:00')
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    public function testEventAtEndOfClosureFails()
    {
        $rule = new TestRuleClosure(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00')
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 12:30:00'),
            Carbon::create('2021-01-01 13:00:00')
        );


        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    public function testEventAtEndOfClosureWithRecurrencePasses()
    {
        $rule = new TestRuleClosure(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00'),
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-02 12:30:00'),
            Carbon::create('2021-01-02 13:00:00')
        );


        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    public function testEventAfterClosurePasses()
    {
        $rule = new TestRuleClosure(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00')
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 13:00:00'),
            Carbon::create('2021-01-01 14:00:00')
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testEventAfterCloseWithRecurrencePasses()
    {
        $rule = new TestRuleClosure(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00'),
            TEDays::build(Carbon::create('2021-01-01'))

        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-02 13:00:00'),
            Carbon::create('2021-01-02 14:00:00')
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testEventOverlappingClosureEndFails()
    {
        $rule = new TestRuleClosure(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00')
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 12:30:00'),
            Carbon::create('2021-01-01 13:30:00')
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    public function testEventOverlappingCloseWithRecurrenceFails()
    {
        $rule = new TestRuleClosure(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00'),
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-02 12:30:00'),
            Carbon::create('2021-01-02 13:30:00')
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }
}
