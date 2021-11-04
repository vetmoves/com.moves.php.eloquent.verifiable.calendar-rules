<?php

namespace Tests\TestCases\Traits;

use Carbon\Carbon;
use Moves\Eloquent\Verifiable\Exceptions\VerifiableConfigurationException;
use Moves\Eloquent\Verifiable\Exceptions\VerifiableRuleConfigurationException;
use Moves\Eloquent\Verifiable\Exceptions\VerificationRuleException;
use Moves\FowlerRecurringEvents\TemporalExpressions\TEDays;
use Tests\Models\Rules\TestRuleUnavailable;
use Tests\Models\Verifiables\TestVerifiableEvent;
use Tests\TestCases\TestCase;

class TRuleUnavailableTest extends TestCase
{
    public function testEndAfterStartOnSameDayEnforced()
    {
        $rule = new TestRuleUnavailable(
            Carbon::create('2021-01-01 13:00:00'),
            Carbon::create('2021-01-01 12:00:00')
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 10:00:00'),
            Carbon::create('2021-01-01 11:00:00')
        );

        $this->expectException(VerifiableRuleConfigurationException::class);
        $this->expectExceptionMessage('Rule start time must be before rule end time.');

        $rule->verify($event);

        $rule = new TestRuleUnavailable(
            Carbon::create('2021-01-01 13:00:00'),
            Carbon::create('2021-01-02 12:00:00')
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 10:00:00'),
            Carbon::create('2021-01-01 11:00:00')
        );

        $this->expectException(VerifiableRuleConfigurationException::class);
        $this->expectExceptionMessage('Rule start time must be before rule end time.');

        $rule->verify($event);
    }

    public function testDuringClosureFails()
    {
        $rule = new TestRuleUnavailable(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00')
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 12:15:00'),
            Carbon::create('2021-01-01 12:45:00')
        );

        $this->expectException(VerificationRuleException::class);
        $this->expectExceptionMessage('This event cannot be booked between');

        $rule->verify($event);

    }

    public function testEventWithEndBeforeStartFails()
    {
        $rule = new TestRuleUnavailable(
            Carbon::create('2021-01-01 08:00:00'),
            Carbon::create('2021-01-01 17:00:00')
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 11:00:00'),
            Carbon::create('2021-01-01 10:00:00')
        );

        $this->expectException(VerifiableConfigurationException::class);

        $rule->verify($event);
    }

    public function testEventDuringClosureWithRecurrenceFails()
    {
        $rule = new TestRuleUnavailable(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00'),
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-02 12:15:00'),
            Carbon::create('2021-01-02 12:45:00')
        );

        $this->expectException(VerificationRuleException::class);
        $this->expectExceptionMessage('This event cannot be booked between');

        $rule->verify($event);
    }

    public function testEventDuringClosureWithIncorrectRecurrencePasses()
    {
        $rule = new TestRuleUnavailable(
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
        $rule = new TestRuleUnavailable(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00')
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 12:15:00')
        );

        $this->expectException(VerificationRuleException::class);
        $this->expectExceptionMessage('This event cannot be booked between');

        $rule->verify($event);
    }

    public function testEventAtStartOfClosureWithRecurrenceFails()
    {
        $rule = new TestRuleUnavailable(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00'),
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-02 12:00:00'),
            Carbon::create('2021-01-02 12:15:00')
        );

        $this->expectException(VerificationRuleException::class);
        $this->expectExceptionMessage('This event cannot be booked between');

        $rule->verify($event);
    }

    public function testEventBeforeClosurePasses()
    {
        $rule = new TestRuleUnavailable(
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
        $rule = new TestRuleUnavailable(
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
        $rule = new TestRuleUnavailable(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00')
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 11:30:00'),
            Carbon::create('2021-01-01 12:30:00')
        );

        $this->expectException(VerificationRuleException::class);
        $this->expectExceptionMessage('This event cannot be booked between');

        $rule->verify($event);
    }

    public function testEventOverlappingClosureStartWithRecurrenceFails()
    {
        $rule = new TestRuleUnavailable(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00'),
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-02 11:30:00'),
            Carbon::create('2021-01-02 12:30:00')
        );

        $this->expectException(VerificationRuleException::class);
        $this->expectExceptionMessage('This event cannot be booked between');

        $rule->verify($event);
    }

    public function testEventAtEndOfClosureFails()
    {
        $rule = new TestRuleUnavailable(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00')
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 12:30:00'),
            Carbon::create('2021-01-01 13:00:00')
        );


        $this->expectException(VerificationRuleException::class);
        $this->expectExceptionMessage('This event cannot be booked between');

        $rule->verify($event);
    }

    public function testEventAtEndOfClosureWithRecurrenceFails()
    {
        $rule = new TestRuleUnavailable(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00'),
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-02 12:30:00'),
            Carbon::create('2021-01-02 13:00:00')
        );


        $this->expectException(VerificationRuleException::class);
        $this->expectExceptionMessage('This event cannot be booked between');

        $rule->verify($event);
    }

    public function testEventAfterClosurePasses()
    {
        $rule = new TestRuleUnavailable(
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
        $rule = new TestRuleUnavailable(
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
        $rule = new TestRuleUnavailable(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00')
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-01 12:30:00'),
            Carbon::create('2021-01-01 13:30:00')
        );

        $this->expectException(VerificationRuleException::class);
        $this->expectExceptionMessage('This event cannot be booked between');

        $rule->verify($event);
    }

    public function testEventOverlappingCloseWithRecurrenceFails()
    {
        $rule = new TestRuleUnavailable(
            Carbon::create('2021-01-01 12:00:00'),
            Carbon::create('2021-01-01 13:00:00'),
            TEDays::build(Carbon::create('2021-01-01'))
        );

        $event = new TestVerifiableEvent(
            Carbon::create('2021-01-02 12:30:00'),
            Carbon::create('2021-01-02 13:30:00')
        );

        $this->expectException(VerificationRuleException::class);
        $this->expectExceptionMessage('This event cannot be booked between');

        $rule->verify($event);
    }
}
