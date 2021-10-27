<?php

namespace Tests\TestCases\Traits;

use Carbon\Carbon;
use Moves\FowlerRecurringEvents\TemporalExpressions\TEDays;
use Tests\Models\Rules\TestRuleOpenClose;
use Tests\Models\Verifiables\TestVerifiableOpenClose;
use Tests\TestCases\TestCase;

class TOpenCloseRuleTest extends TestCase
{
    public function testCloseAfterOpenOnSameDayEnforced()
    {
        $rule = new TestRuleOpenClose(
            Carbon::create('2021-01-01 17:00:00'),
            Carbon::create('2021-01-01 08:00:00')
        );

        $event = new TestVerifiableOpenClose(
            Carbon::create('2021-01-01 10:00:00'),
            Carbon::create('2021-01-01 11:00:00')
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);

        $rule = new TestRuleOpenClose(
            Carbon::create('2021-01-01 17:00:00'),
            Carbon::create('2021-01-02 08:00:00')
        );

        $event = new TestVerifiableOpenClose(
            Carbon::create('2021-01-01 10:00:00'),
            Carbon::create('2021-01-01 11:00:00')
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    public function testCorrectEventPasses()
    {
        $rule = new TestRuleOpenClose(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 17:00:00')
        );

        $event = new TestVerifiableOpenClose(
            Carbon::create('2021-01-01 10:00:00'),
            Carbon::create('2021-01-01 11:00:00')
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testEventWithEndBeforeStartFails()
    {
        $rule = new TestRuleOpenClose(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 17:00:00')
        );

        $event = new TestVerifiableOpenClose(
            Carbon::create('2021-01-01 11:00:00'),
            Carbon::create('2021-01-01 10:00:00')
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    public function testCorrectEventWithRecurrencePasses()
    {
        $rule = new TestRuleOpenClose(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $event = new TestVerifiableOpenClose(
            Carbon::create('2021-01-02 10:00:00'),
            Carbon::create('2021-01-02 11:00:00')
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testCorrectEventWithIncorrectRecurrenceFails()
    {
        $rule = new TestRuleOpenClose(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            TEDays::build(Carbon::create('2021-01-01'))->setFrequency(2)
        );

        $event = new TestVerifiableOpenClose(
            Carbon::create('2021-01-02 10:00:00'),
            Carbon::create('2021-01-02 11:00:00')
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    public function testEventAtOpenPasses()
    {
        $rule = new TestRuleOpenClose(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 17:00:00')
        );

        $event = new TestVerifiableOpenClose(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 09:00:00')
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testEventAtOpenWithRecurrencePasses()
    {
        $rule = new TestRuleOpenClose(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $event = new TestVerifiableOpenClose(
            Carbon::create('2021-01-02 08:00:00'),
            Carbon::create('2021-01-02 09:00:00')
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testEventBeforeOpenFails()
    {
        $rule = new TestRuleOpenClose(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 17:00:00')
        );

        $event = new TestVerifiableOpenClose(
            Carbon::create('2021-01-01 06:00:00'),
            Carbon::create('2021-01-01 07:00:00')
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    public function testEventBeforeOpenWithRecurrenceFails()
    {
        $rule = new TestRuleOpenClose(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            TEDays::build(Carbon::create('2021-01-01'))

        );

        $event = new TestVerifiableOpenClose(
            Carbon::create('2021-01-02 06:00:00'),
            Carbon::create('2021-01-02 07:00:00')
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    public function testEventOverlappingOpenFails()
    {
        $rule = new TestRuleOpenClose(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 17:00:00')
        );

        $event = new TestVerifiableOpenClose(
            Carbon::create('2021-01-01 07:30:00'),
            Carbon::create('2021-01-01 08:30:00')
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    public function testEventOverlappingOpenWithRecurrenceFails()
    {
        $rule = new TestRuleOpenClose(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $event = new TestVerifiableOpenClose(
            Carbon::create('2021-01-02 07:30:00'),
            Carbon::create('2021-01-02 08:30:00')
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    //

    public function testEventAtClosePasses()
    {
        $rule = new TestRuleOpenClose(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 17:00:00')
        );

        $event = new TestVerifiableOpenClose(
            Carbon::create('2021-01-01 16:00:00'),
            Carbon::create('2021-01-01 17:00:00')
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testEventAtCloseWithRecurrencePasses()
    {
        $rule = new TestRuleOpenClose(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $event = new TestVerifiableOpenClose(
            Carbon::create('2021-01-02 16:00:00'),
            Carbon::create('2021-01-02 17:00:00')
        );

        $this->assertTrue($rule->verify($event));
    }

    public function testEventAfterCloseFails()
    {
        $rule = new TestRuleOpenClose(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 17:00:00')
        );

        $event = new TestVerifiableOpenClose(
            Carbon::create('2021-01-01 18:00:00'),
            Carbon::create('2021-01-01 19:00:00')
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    public function testEventAfterCloseWithRecurrenceFails()
    {
        $rule = new TestRuleOpenClose(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            TEDays::build(Carbon::create('2021-01-01'))

        );

        $event = new TestVerifiableOpenClose(
            Carbon::create('2021-01-02 18:00:00'),
            Carbon::create('2021-01-02 19:00:00')
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    public function testEventOverlappingCloseFails()
    {
        $rule = new TestRuleOpenClose(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 17:00:00')
        );

        $event = new TestVerifiableOpenClose(
            Carbon::create('2021-01-01 16:30:00'),
            Carbon::create('2021-01-01 17:30:00')
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }

    public function testEventOverlappingCloseWithRecurrenceFails()
    {
        $rule = new TestRuleOpenClose(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 17:00:00'),
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $event = new TestVerifiableOpenClose(
            Carbon::create('2021-01-02 16:30:00'),
            Carbon::create('2021-01-02 17:30:00')
        );

        $this->expectException(\Exception::class);

        $rule->verify($event);
    }
}
